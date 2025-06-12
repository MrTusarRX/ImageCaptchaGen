<?php
session_start();
header('Content-Type: audio/mpeg');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
if (!isset($_SESSION['captcha'])) {
    die();
}

$captchaText = $_SESSION['captcha'];
function generateAudioCaptcha($text) {
    $tempFile = tempnam(sys_get_temp_dir(), 'audio_captcha') . '.mp3';
    $spokenText = implode('... ', str_split($text));    
    $googleTTSUrl = "https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . 
                    urlencode($spokenText) . "&tl=en";
    $audioData = file_get_contents($googleTTSUrl);
    
    if ($audioData === false) {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $voice = 'Microsoft David Desktop';
            $tempFile = tempnam(sys_get_temp_dir(), 'audio_captcha') . '.wav';
            $command = "PowerShell -Command \"Add-Type -AssemblyName System.Speech; " .
                       "\$speak = New-Object System.Speech.Synthesis.SpeechSynthesizer; " .
                       "\$speak.SelectVoice('$voice'); " .
                       "\$speak.SetOutputToWaveFile('$tempFile'); " .
                       "\$speak.Speak('$spokenText'); " .
                       "\$speak.Dispose();\"";
            exec($command);
            $audioData = file_get_contents($tempFile);
        } else {
            $tempFile = tempnam(sys_get_temp_dir(), 'audio_captcha') . '.wav';
            exec("espeak -v en -s 120 -w $tempFile '$spokenText'");
            $audioData = file_get_contents($tempFile);
        }
    }    
    if (strpos($tempFile, '.wav') !== false && extension_loaded('ffmpeg')) {
        $mp3File = str_replace('.wav', '.mp3', $tempFile);
        exec("ffmpeg -i $tempFile -codec:a libmp3lame -qscale:a 2 $mp3File");
        $audioData = file_get_contents($mp3File);
        unlink($mp3File);
    }
    
    if (file_exists($tempFile)) {
        unlink($tempFile);
    }
    
    return $audioData;
}

$audio = generateAudioCaptcha($captchaText);
echo $audio;
?>