<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechCorp - Système de Gestion</title>
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
                    <a href="index.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-purple-500/20 transition-all duration-300">
                        <i data-feather="home" class="w-5 h-5"></i>
                        <span>Accueil</span>
                    </a>
                    <a href="feedback.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-white/10 transition-all duration-300">
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
    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16 animate-fade-in">
            <h2 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white via-purple-200 to-green-200 bg-clip-text text-transparent">
                Système de Gestion TechCorp
            </h2>
            <p class="text-xl text-white/80 max-w-3xl mx-auto leading-relaxed">
                Plateforme moderne pour la gestion des retours clients et l'administration système.
                Interface intuitive et sécurisée pour une expérience utilisateur optimale.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <!-- Feedback Card -->
            <div class="glass-effect rounded-2xl p-8 border border-white/20 hover:border-white/40 transition-all duration-300 animate-slide-up">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                    <i data-feather="message-circle" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Gestion des Retours</h3>
                <p class="text-white/70 mb-6 leading-relaxed">
                    Collectez et gérez les retours clients de manière efficace. 
                    Interface intuitive pour une expérience utilisateur optimale.
                </p>
                <a href="feedback.php" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-300">
                    <span>Accéder</span>
                    <i data-feather="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>

            <!-- Admin Card -->
            <div class="glass-effect rounded-2xl p-8 border border-white/20 hover:border-white/40 transition-all duration-300 animate-slide-up" style="animation-delay: 0.2s;">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                    <i data-feather="settings" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Administration</h3>
                <p class="text-white/70 mb-6 leading-relaxed">
                    Panneau d'administration complet pour surveiller les performances 
                    et gérer les configurations système.
                </p>
                <a href="admin.php" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-300">
                    <span>Accéder</span>
                    <i data-feather="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>

            <!-- Security Card -->
            <div class="glass-effect rounded-2xl p-8 border border-white/20 hover:border-white/40 transition-all duration-300 animate-slide-up" style="animation-delay: 0.4s;">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-6">
                    <i data-feather="shield" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Sécurité Avancée</h3>
                <p class="text-white/70 mb-6 leading-relaxed">
                    Protection des données et authentification sécurisée. 
                    Conformité aux standards de sécurité les plus élevés.
                </p>
                <div class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 rounded-lg">
                    <span>Actif</span>
                    <i data-feather="check" class="w-5 h-5"></i>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="glass-effect rounded-2xl p-8 border border-white/20 animate-slide-up" style="animation-delay: 0.6s;">
            <h3 class="text-2xl font-bold mb-6 text-center">Statistiques Système</h3>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-400 mb-2">99.9%</div>
                    <div class="text-white/70">Uptime</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-400 mb-2">24/7</div>
                    <div class="text-white/70">Support</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-400 mb-2">256-bit</div>
                    <div class="text-white/70">Chiffrement</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-400 mb-2">ISO</div>
                    <div class="text-white/70">Certification</div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 glass-effect border-t border-white/10 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-white/60">
                <p>&copy; 2024 TechCorp. Tous droits réservés. | Système de gestion sécurisé</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Feather icons
        feather.replace();
        
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html> 