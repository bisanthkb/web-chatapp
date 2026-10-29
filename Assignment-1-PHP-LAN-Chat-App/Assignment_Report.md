# Assignment 1: LAN Talk - Simple Multi-User Local Area Network Chat Application

**Name:** [Your Name]  
**Roll Number:** [Your Roll Number]  
**Class / Semester:** S7 CSEA / Information Technology  
**Subject:** Web Technology / PHP  
**Date:** 29 October 2026  

---

## 1. Introduction

**LAN Talk** is a lightweight, real-time-capable web chat application engineered to facilitate communication between two or more devices interconnected over the same Local Area Network (Wi-Fi or Ethernet). Built strictly using **PHP, HTML5, and CSS**, the application executes on an Apache HTTP server (via XAMPP) without requiring SQL databases, JavaScript, AJAX polling frameworks, WebSockets, or third-party libraries. 

Persistent storage is accomplished using atomic file append operations on a flat text ledger (`messages.txt`).

---

## 2. System Architecture & File Directory

The project consists of five foundational files:

| File Name | Function & Operational Description |
| :--- | :--- |
| `index.php` | Landing/Authentication portal. Captures the user's handle and stores it securely within a PHP session. |
| `chat.php` | Core chat view and controller. Persists incoming messages, sanitizes inputs, and streams dialogue threads. |
| `logout.php` | Session invalidation script that flushes session variables and returns the user to `index.php`. |
| `messages.txt` | Flat-file persistent datastore recording serialized message records (`Sender\|Message\n`). |
| `style.css` | Stylesheet defining the card layouts, chat bubbles, responsive inputs, and color theme. |

---

## 3. Working Mechanism & Data Flow

1. **Session Initialization:**  
   When a user accesses `index.php`, they submit their display name. PHP validates that the string is non-empty, strips delimiter characters (`|`), initializes `$_SESSION['user']`, and executes a redirection (`header('Location: chat.php')`).

2. **Message Persistence (PRG Pattern):**  
   Inside `chat.php`, users compose messages and submit them via HTTP POST. The script strips newline characters to preserve single-line serialization, acquires an exclusive file lock (`LOCK_EX`), and appends the entry formatted as `$me . '|' . $text . "\n"`.  
   Crucially, it executes a **Post/Redirect/Get (PRG)** pattern by issuing a `header('Location: chat.php')`, eliminating duplicate submissions on browser refresh.

3. **Message Rendering & XSS Sanitization:**  
   When rendering, `chat.php` reads `messages.txt` into an array using `file(..., FILE_IGNORE_NEW_LINES)`. Each line is split into sender and content. All rendered user strings are wrapped with `htmlspecialchars()` to prevent Cross-Site Scripting (XSS) vulnerabilities.

4. **Speech Bubble Differentiation:**  
   Messages sent by the current active session user are rendered on the right in green (`class="bubble mine"`), whereas incoming messages from peer LAN clients appear on the left in white (`class="bubble theirs"`).

---

## 4. Setup and Execution (Server Machine)

1. Move or clone the project folder into your local XAMPP web root:
   ```text
   C:\xampp\htdocs\chat-app
   ```
2. Launch the **XAMPP Control Panel** and start the **Apache** server module.
3. Open a web browser on the host machine and navigate to:
   ```text
   http://localhost/chat-app/
   ```

---

## 5. Connecting Secondary Devices Over Local Wi-Fi

1. **Retrieve Server IPv4 Address:**  
   Open Command Prompt / PowerShell on the server laptop and execute:
   ```cmd
   ipconfig
   ```
   Note the `IPv4 Address` (e.g., `192.168.1.15`).
2. **Connect Client Devices:**  
   Ensure the second laptop or mobile phone is connected to the identical Wi-Fi network.
3. **Access Application:**  
   Open a browser on the second device and browse to:
   ```text
   http://192.168.1.15/chat-app/
   ```
   *(Note: If connectivity fails, configure Windows Firewall to permit incoming TCP connections on port 80 for Apache HTTP Server).*

---

## 6. Concurrency & File Synchronization

Because the Apache server executes centrally on the host laptop, both clients interact with the singular server-side `messages.txt` datastore. Operating system-level atomic appending (`FILE_APPEND | LOCK_EX`) ensures that concurrent transmissions from multiple LAN users do not corrupt file integrity.

---

## 7. Conclusion

LAN Talk illustrates how stateful, collaborative network applications can be engineered using fundamental HTTP forms, PHP session mechanics, and flat-file I/O. The system provides zero-dependency deployment, making it ideal for isolated intranets, lab environments, and emergency communications.
