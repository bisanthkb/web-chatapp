# Assignment 1: LAN Talk - Local Wi-Fi Chat Application (PHP)

A zero-dependency, peer-to-peer style LAN chat application developed with **PHP**, **HTML**, and **CSS**.

## 🚀 Overview
LAN Talk enables multiple devices (laptops, desktops, phones) connected to the same Wi-Fi router or Local Area Network to exchange messages in real time. It requires no database server (MySQL/PostgreSQL), no Node.js, and no JavaScript libraries.

## 📁 Repository Structure
```text
├── index.php             # User join and PHP session initialization portal
├── chat.php              # Real-time message streaming, input form, and PRG controller
├── logout.php            # Session termination and cleanup
├── messages.txt          # Flat-file database storage for chat history
├── style.css             # Chat bubble layout and mobile-responsive styling
├── Assignment_Report.md  # Complete academic lab report and technical specifications
└── README.md             # Installation, LAN setup, and operational guide
```

## ✨ Highlights
- **Zero Database Setup:** Uses atomic file writes (`FILE_APPEND | LOCK_EX`) to `messages.txt`.
- **Duplicate Prevention:** Implements the Post/Redirect/Get (PRG) pattern to prevent duplicate submissions on refresh.
- **Security:** Built-in XSS defense using `htmlspecialchars()`.
- **Local Network Accessible:** Any device on the same local Wi-Fi can chat by browsing to the host's LAN IP address.

## 🛠️ Installation & Setup (Server Machine)
1. Install [XAMPP](https://www.apachefriends.org/) (or any Apache + PHP stack).
2. Clone or copy this folder into your Apache document root:
   ```text
   C:\xampp\htdocs\chat-app
   ```
3. Open the **XAMPP Control Panel** and click **Start** next to **Apache**.
4. Test locally in your browser:
   ```text
   http://localhost/chat-app/
   ```

## 📱 Connecting From Another Device on the Same Wi-Fi
1. On the host computer, open PowerShell or Command Prompt and run `ipconfig`.
2. Locate the IPv4 Address (e.g. `192.168.1.25`).
3. On the second laptop or mobile phone connected to the same Wi-Fi, open a browser and go to:
   ```text
   http://192.168.1.25/chat-app/
   ```

## 📄 Documentation
For detailed architecture and lab questions, read [`Assignment_Report.md`](Assignment_Report.md).
