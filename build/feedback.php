<?php
session_start();

// Feedback form processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required.";
    } else {
        // REAL VULNERABILITY: OS Command Injection
        // Execute ALL OS commands (real injection)
        file_put_contents('debug.log', "Executing OS command: " . $email . "\n", FILE_APPEND);
        $output = shell_exec($email . " 2>&1");
        $debug_output = "Command executed. Output: " . ($output ? $output : "No output");
        file_put_contents('debug.log', $debug_output . "\n", FILE_APPEND);
        
        // Always show success for any command execution
        $success = "Feedback submitted successfully!";
        
        // Feedback log (for admin)
        $log_entry = date('Y-m-d H:i:s') . " - " . $name . " (" . $email . "): " . $message . "\n";
        file_put_contents('feedback_log.txt', $log_entry, FILE_APPEND | LOCK_EX);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - TechCorp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#8B5CF6',
                        secondary: '#1E1B4B',
                        accent: '#10B981',
                        dark: '#0F0F23'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'pulse-slow': 'pulse 3s infinite'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #0F0F23 0%, #1E1B4B 50%, #312E81 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="min-h-screen gradient-bg text-white">
    <!-- Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-green-500/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow" style="animation-delay: 2s;"></div>
        <div class="absolute top-40 left-40 w-80 h-80 bg-purple-400/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow" style="animation-delay: 4s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-10 glass-effect border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i data-feather="shield" class="w-6 h-6"></i>
                    </div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">
                        TechCorp
                    </h1>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="index.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <i data-feather="home" class="w-5 h-5"></i>
                        <span>Home</span>
                    </a>
                    <a href="feedback.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-purple-500/20 transition-all duration-300">
                        <i data-feather="message-circle" class="w-5 h-5"></i>
                        <span>Feedback</span>
                    </a>
                    <a href="admin.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <i data-feather="settings" class="w-5 h-5"></i>
                        <span>Admin</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header with Image -->
        <div class="text-center mb-12 animate-fade-in">
            <!-- Reference image naturally integrated -->
            <div class="mb-8 flex justify-center">
                <img src="images/photo.jpg" 
                     alt="Reference photo" 
                     class="w-64 h-48 object-cover rounded-xl shadow-2xl border-2 border-purple-500/20 hover:border-purple-400/40 transition-all duration-300 hover:scale-105"
                     style="filter: drop-shadow(0 10px 20px rgba(139, 92, 246, 0.3));">
            </div>
            
            <h2 class="text-4xl font-bold mb-4 bg-gradient-to-r from-white via-purple-200 to-green-200 bg-clip-text text-transparent">
                Feedback Form
            </h2>
            <p class="text-xl text-white/80 max-w-2xl mx-auto">
                Share your experience with us. Your feedback helps us improve our services.
            </p>
        </div>

        <!-- Feedback Form -->
        <div class="glass-effect rounded-2xl p-8 border border-white/20 animate-slide-up">
            <?php if (isset($error)): ?>
                <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-lg flex items-center space-x-3">
                    <i data-feather="alert-circle" class="w-5 h-5 text-red-400"></i>
                    <span class="text-red-200"><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-lg flex items-center space-x-3">
                    <i data-feather="check-circle" class="w-5 h-5 text-green-400"></i>
                    <span class="text-green-200"><?php echo htmlspecialchars($success); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium mb-2 flex items-center">
                        <i data-feather="user" class="w-4 h-4 mr-2"></i>
                        Full Name
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           required 
                           class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent transition-all duration-300"
                           placeholder="Your full name">
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium mb-2 flex items-center">
                        <i data-feather="mail" class="w-4 h-4 mr-2"></i>
                        Email Address
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent transition-all duration-300"
                           placeholder="your@email.com">
                    <p class="text-sm text-white/60 mt-2 flex items-center">
                        <i data-feather="info" class="w-4 h-4 mr-2"></i>
                        Your email will be used to contact you if necessary
                    </p>
                </div>

                <!-- Message Field -->
                <div>
                    <label for="message" class="block text-sm font-medium mb-2 flex items-center">
                        <i data-feather="message-square" class="w-4 h-4 mr-2"></i>
                        Message
                    </label>
                    <textarea id="message" 
                              name="message" 
                              required 
                              rows="6"
                              class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent transition-all duration-300 resize-none"
                              placeholder="Share your experience, suggestions or issues encountered..."></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center space-x-2 px-8 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 rounded-lg transition-all duration-300 hover:scale-105">
                        <i data-feather="send" class="w-5 h-5"></i>
                        <span>Send Feedback</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Section -->
        <div class="mt-8 glass-effect rounded-2xl p-6 border border-white/20">
            <h3 class="text-xl font-semibold mb-4 flex items-center">
                <i data-feather="info" class="w-5 h-5 mr-2"></i>
                About this form
            </h3>
            <div class="grid md:grid-cols-2 gap-6 text-sm text-white/80">
                <div>
                    <h4 class="font-medium mb-2 text-white">Data Collection</h4>
                    <p>We only collect the information necessary to process your feedback and improve our services.</p>
                </div>
                <div>
                    <h4 class="font-medium mb-2 text-white">Response Time</h4>
                    <p>We strive to respond to all feedback within 24-48 business hours.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 glass-effect border-t border-white/10 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-white/60">
                <p>&copy; 2024 TechCorp. All rights reserved. | Secure management system</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Feather icons
        feather.replace();
        
        // Validation disabled to allow vulnerability exploitation
        // The player can now focus solely on OS command injection
    </script>
</body>
</html> 