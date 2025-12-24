# ImageCaptchaGen

ImageCaptchaGen is a lightweight PHP-based CAPTCHA generator designed to protect web forms from bots and automated submissions.  
It supports both **image CAPTCHA** and **audio CAPTCHA** for better accessibility.

---

## 🚀 Features

- 🖼️ Image CAPTCHA generation
- 🎧 Audio CAPTCHA support
- 🔐 Prevents spam and bot attacks
- ⚡ Lightweight and fast
- 🧩 No external dependencies
- ♿ Accessible for visually impaired users
- 🛠️ Easy to integrate into any PHP project

---

## 📂 Project Structure

```
ImageCaptchaGen/
├── index.php           # Demo usage
├── generate.php        # Image CAPTCHA generator
├── audio_captcha.php   # Audio CAPTCHA generator
└── README.md
```

---

## 📋 Requirements

- PHP 5.6 or higher
- PHP GD extension enabled

Make sure GD is enabled in your `php.ini`:

```
extension=gd
```

---

## 📥 Installation

1. Clone the repository:
   ```
   git clone https://github.com/MrTusarRX/ImageCaptchaGen.git
   ```

2. Move the files to your web server directory:
   ```
   /htdocs/ImageCaptchaGen
   ```

3. Open `index.php` in your browser:
   ```
   http://localhost/ImageCaptchaGen/index.php
   ```

---

## 🖼️ Display Image CAPTCHA

```html
<img src="generate.php" alt="CAPTCHA Image">
```

---

## 🎧 Audio CAPTCHA

```html
<audio controls>
  <source src="audio_captcha.php" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
```

---

## ✅ CAPTCHA Validation

```php
session_start();

if ($_POST['captcha'] === $_SESSION['captcha_text']) {
    echo "CAPTCHA verified successfully!";
} else {
    echo "Invalid CAPTCHA!";
}
```

---

## ⚙️ Customization

You can customize the CAPTCHA by editing:

- Image width & height
- Text length
- Fonts
- Colors
- Noise & distortion level

Files to edit:
- `generate.php`
- `audio_captcha.php`

---

## 🧠 How It Works

- A random string is generated
- The string is stored in a PHP session
- An image/audio is rendered using PHP GD
- User input is validated against the session value

---

## 🔒 Why Use ImageCaptchaGen?

- Protects login & registration forms
- Reduces spam submissions
- Simple alternative to heavy CAPTCHA services
- Works offline (no API required)

---

## 📜 License

This project is open-source and free to use.

---

## ⭐ Support

If you find this project useful, please consider giving it a ⭐ on GitHub.

Repository:  
https://github.com/MrTusarRX/ImageCaptchaGen
