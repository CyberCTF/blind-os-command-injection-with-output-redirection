<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - TechCorp</title>
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
                    <a href="feedback.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <i data-feather="message-circle" class="w-5 h-5"></i>
                        <span>Feedback</span>
                    </a>
                    <a href="admin.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-purple-500/20 transition-all duration-300">
                        <i data-feather="settings" class="w-5 h-5"></i>
                        <span>Admin</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <h2 class="text-4xl font-bold mb-4 bg-gradient-to-r from-white via-purple-200 to-green-200 bg-clip-text text-transparent">
                Administration Panel
            </h2>
            <p class="text-xl text-white/80 max-w-2xl mx-auto">
                TechCorp system management and monitoring interface
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- System Status -->
            <div class="glass-effect rounded-2xl p-6 border border-white/20 animate-slide-up">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i data-feather="activity" class="w-5 h-5 mr-2"></i>
                        System Status
                    </h3>
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-white/70">Web Server</span>
                        <span class="text-green-400 font-medium">Operational</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-white/70">Database</span>
                        <span class="text-green-400 font-medium">Connected</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-white/70">Security</span>
                        <span class="text-green-400 font-medium">Active</span>
                    </div>
                </div>
            </div>

            <!-- Feedback Count -->
            <div class="glass-effect rounded-2xl p-6 border border-white/20 animate-slide-up" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i data-feather="message-circle" class="w-5 h-5 mr-2"></i>
                        Feedback Received
                    </h3>
                    <i data-feather="trending-up" class="w-5 h-5 text-green-400"></i>
                </div>
                <?php
                $feedback_count = 0;
                if (file_exists('feedback_log.txt')) {
                    $feedback_count = count(file('feedback_log.txt'));
                }
                ?>
                <div class="text-3xl font-bold text-purple-400 mb-2"><?php echo $feedback_count; ?></div>
                <p class="text-white/60 text-sm">Messages processed</p>
            </div>

            <!-- System Uptime -->
            <div class="glass-effect rounded-2xl p-6 border border-white/20 animate-slide-up" style="animation-delay: 0.4s;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i data-feather="clock" class="w-5 h-5 mr-2"></i>
                        Uptime
                    </h3>
                    <i data-feather="zap" class="w-5 h-5 text-yellow-400"></i>
                </div>
                <?php
                $uptime = "N/A";
                $uptime_output = shell_exec('uptime -p 2>/dev/null');
                if ($uptime_output) {
                    $uptime = trim($uptime_output);
                }
                ?>
                <div class="text-2xl font-bold text-yellow-400 mb-2"><?php echo htmlspecialchars($uptime); ?></div>
                <p class="text-white/60 text-sm">System online</p>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="glass-effect rounded-2xl p-8 border border-white/20 animate-slide-up" style="animation-delay: 0.6s;">
            <h3 class="text-2xl font-bold mb-6 flex items-center">
                <i data-feather="list" class="w-6 h-6 mr-3"></i>
                Recent Activity
            </h3>
            
            <?php if (file_exists('feedback_log.txt')): ?>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <?php
                    $lines = array_reverse(file('feedback_log.txt'));
                    $recent_lines = array_slice($lines, 0, 10);
                    foreach ($recent_lines as $line):
                        $line = trim($line);
                        if (!empty($line)):
                    ?>
                        <div class="flex items-start space-x-4 p-4 bg-white/5 rounded-lg">
                            <div class="w-2 h-2 bg-purple-400 rounded-full mt-2 flex-shrink-0"></div>
                            <div class="flex-1">
                                <p class="text-white/90 text-sm"><?php echo htmlspecialchars($line); ?></p>
                            </div>
                        </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <i data-feather="inbox" class="w-12 h-12 text-white/40 mx-auto mb-4"></i>
                    <p class="text-white/60">No recent activity</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- System Info -->
        <div class="mt-8 grid md:grid-cols-2 gap-8">
            <!-- Server Info -->
            <div class="glass-effect rounded-2xl p-6 border border-white/20 animate-slide-up" style="animation-delay: 0.8s;">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <i data-feather="server" class="w-5 h-5 mr-2"></i>
                    Server Information
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-white/70">System</span>
                        <span class="text-white">Linux</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-white/70">PHP Version</span>
                        <span class="text-white"><?php echo phpversion(); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-white/70">Web Server</span>
                        <span class="text-white">Apache</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-white/70">Port</span>
                        <span class="text-white">80</span>
                    </div>
                </div>
            </div>

            <!-- Security Status -->
            <div class="glass-effect rounded-2xl p-6 border border-white/20 animate-slide-up" style="animation-delay: 1s;">
                <h3 class="text-xl font-semibold mb-4 flex items-center">
                    <i data-feather="shield" class="w-5 h-5 mr-2"></i>
                    Security Status
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-white/70">Firewall</span>
                        <span class="text-green-400 font-medium">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-white/70">SSL/TLS</span>
                        <span class="text-green-400 font-medium">Configured</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-white/70">Updates</span>
                        <span class="text-yellow-400 font-medium">Up to date</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-white/70">Monitoring</span>
                        <span class="text-green-400 font-medium">24/7</span>
                    </div>
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
        
        // Auto-refresh stats every 30 seconds
        setInterval(function() {
            // You could add AJAX calls here to refresh stats
            console.log('Stats updated');
        }, 30000);
    </script>
</body>
</html> 