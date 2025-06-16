<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rick and Morty Proxy API</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Base styles */
                body {
                    font-family: 'Instrument Sans', sans-serif;
                    background-color: #f5f5f7;
                    color: #333;
                    margin: 0;
                    padding: 0;
                    line-height: 1.6;
                }
                
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 20px;
                }
                
                .hero {
                    background-color: #121212;
                    color: #fff;
                    padding: 60px 20px;
                    text-align: center;
                    background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://rickandmortyapi.com/api/character/avatar/1.jpeg');
                    background-size: cover;
                    background-position: center;
                    background-blend-mode: overlay;
                }
                
                .hero h1 {
                    font-size: 3rem;
                    margin-bottom: 20px;
                    font-weight: 700;
                }
                
                .hero p {
                    font-size: 1.2rem;
                    max-width: 800px;
                    margin: 0 auto 30px;
                }
                
                .btn {
                    display: inline-block;
                    padding: 12px 24px;
                    background-color: #00b0c8;
                    color: #fff;
                    text-decoration: none;
                    border-radius: 4px;
                    font-weight: 500;
                    transition: all 0.3s ease;
                    margin: 10px;
                }
                
                .btn:hover {
                    background-color: #008a9b;
                    transform: translateY(-2px);
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                }
                
                .features {
                    padding: 60px 20px;
                    background-color: #fff;
                }
                
                .features h2 {
                    text-align: center;
                    margin-bottom: 40px;
                    font-size: 2.2rem;
                }
                
                .feature-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                    grid-gap: 30px;
                    justify-content: center;
                }
                
                .feature-card {
                    background-color: #f9f9f9;
                    border-radius: 8px;
                    padding: 30px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                    transition: all 0.3s ease;
                }
                
                .feature-card:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                }
                
                .feature-card h3 {
                    margin-top: 0;
                    font-size: 1.5rem;
                    margin-bottom: 15px;
                    color: #00b0c8;
                }
                
                .api-section {
                    background-color: #f5f5f7;
                    padding: 60px 20px;
                }
                
                .api-box {
                    background-color: #1e1e1e;
                    border-radius: 8px;
                    padding: 20px;
                    color: #f1f1f1;
                    font-family: monospace;
                    margin-bottom: 20px;
                    overflow-x: auto;
                }
                
                .endpoint {
                    color: #00b0c8;
                    font-weight: bold;
                }
                
                .method {
                    background-color: #4CAF50;
                    color: white;
                    padding: 4px 8px;
                    border-radius: 4px;
                    margin-right: 10px;
                    font-size: 0.9rem;
                }
                
                footer {
                    background-color: #121212;
                    color: #fff;
                    text-align: center;
                    padding: 30px 20px;
                }
                
                .docs-section {
                    padding: 60px 20px;
                    background-color: #fff;
                    text-align: center;
                }
                
                .docs-links {
                    display: flex;
                    justify-content: center;
                    flex-wrap: wrap;
                    gap: 20px;
                    margin-top: 30px;
                }
                
                .docs-link {
                    display: flex;
                    align-items: center;
                    padding: 15px 30px;
                    background-color: #f5f5f7;
                    border-radius: 8px;
                    text-decoration: none;
                    color: #333;
                    font-weight: 500;
                    transition: all 0.3s ease;
                }
                
                .docs-link:hover {
                    background-color: #e5e5e7;
                    transform: translateY(-2px);
                }
                
                .docs-link svg {
                    margin-right: 10px;
                    width: 24px;
                    height: 24px;
                }
                
                @media (max-width: 768px) {
                    .hero h1 {
                        font-size: 2.5rem;
                    }
                    
                    .feature-grid {
                        grid-template-columns: 1fr;
                        max-width: 100% !important;
                    }
                }
                
                .navbar {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 20px;
                    background-color: #121212;
                    color: #fff;
                }
                
                .logo {
                    font-size: 1.5rem;
                    font-weight: 700;
                    color: #fff;
                    text-decoration: none;
                }
                
                .nav-links a {
                    color: #fff;
                    text-decoration: none;
                    margin-left: 20px;
                    transition: all 0.3s ease;
                }
                
                .nav-links a:hover {
                    color: #00b0c8;
                }
                
                /* Dark mode styles */
                @media (prefers-color-scheme: dark) {
                    body {
                        background-color: #121212;
                        color: #f5f5f7;
                    }
                    
                    .features, .docs-section {
                        background-color: #1e1e1e;
                        color: #f5f5f7;
                    }
                    
                    .feature-card {
                        background-color: #2d2d2d;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                    }
                    
                    .api-section {
                        background-color: #121212;
                    }
                    
                    .docs-link {
                        background-color: #2d2d2d;
                        color: #f5f5f7;
                    }
                    
                    .docs-link:hover {
                        background-color: #3d3d3d;
                    }
                }
            </style>
        @endif
    </head>
    <body>
        <div class="navbar">
            <a href="{{ url('/') }}" class="logo">Rick and Morty API</a>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                @endif
                <a href="{{ url('/docs') }}">API Docs</a>
            </div>
        </div>

        <section class="hero">
            <div class="container">
                <h1>Rick and Morty Proxy API</h1>
                <p>A Laravel-based API that serves as a proxy for Rick and Morty show character data. Built with Laravel and Docker, this API returns JSON data and is designed to be accessible by various clients, including mobile applications.</p>
                <div>
                    <a href="{{ url('/docs') }}" class="btn">View API Documentation</a>
                    <a href="https://github.com/janis-tech/rick-and-morty-proxy-api" class="btn">GitHub Repository</a>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <h2>Features</h2>                <div class="feature-grid" style="max-width: 700px; margin: 0 auto;">
                    <div class="feature-card">
                        <h3>Browse Characters</h3>
                        <p>Get a paginated list of all characters from the show with comprehensive details. Includes ability to search by name and status.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Character Details</h3>
                        <p>Load detailed information for a specific character by their unique identifier.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="api-section">
            <div class="container">
                <h2>API Endpoints</h2>
                <div class="api-box">
                    <p><span class="method">GET</span><span class="endpoint">/api/v1/characters</span></p>
                    <p>Get a paginated list of all characters (supports ?name= and ?status= query parameters)</p>
                </div>
                <div class="api-box">
                    <p><span class="method">GET</span><span class="endpoint">/api/v1/characters/{id}</span></p>
                    <p>Get detailed information about a specific character</p>
                </div>
            </div>
        </section>

        <section class="docs-section">
            <div class="container">
                <h2>API Documentation</h2>
                <p>Explore our comprehensive API documentation to get started with the Rick and Morty Proxy API.</p>
                <div class="docs-links">
                    <a href="{{ url('/docs') }}" class="docs-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                        Browse API Documentation
                    </a>
                    <a href="{{ url('/docs/collection.json') }}" class="docs-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        View Postman Collection
                    </a>
                    <a href="{{ url('/docs/openapi.yaml') }}" class="docs-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        View OpenAPI Spec
                    </a>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <h2>Technology Stack</h2>
                <div class="feature-grid" style="max-width: 1000px; margin: 0 auto;">
                    <div class="feature-card">
                        <h3>PHP 8.4</h3>
                        <p>Utilizing the latest PHP features for improved performance and developer experience.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Laravel Framework</h3>
                        <p>Built on the robust Laravel framework for reliable and maintainable code.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Docker via Laravel Sail</h3>
                        <p>Easy development and deployment with containerized environments.</p>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="container">
                <p>© {{ date('Y') }} Rick and Morty Proxy API. All rights reserved.</p>
                <p>Developed with Laravel and Docker.</p>
            </div>
        </footer>
    </body>
</html>
