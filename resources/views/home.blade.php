<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel + PostgreSQL Demo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0a0a0f;
            --bg-secondary: #12121a;
            --bg-card: #1a1a25;
            --accent: #ff6b35;
            --accent-glow: rgba(255, 107, 53, 0.3);
            --text-primary: #f5f5f7;
            --text-secondary: #8b8b9a;
            --border: #2a2a3a;
            --success: #4ade80;
            --error: #f87171;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Bricolage Grotesque', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                radial-gradient(ellipse at 20% 20%, rgba(255, 107, 53, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(139, 92, 246, 0.05) 0%, transparent 70%);
        }

        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-image: 
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 60px 24px;
        }

        header {
            text-align: center;
            margin-bottom: 60px;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--accent), #ff8f65);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 8px 32px var(--accent-glow);
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--text-primary), var(--text-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 1.25rem;
            margin-top: 12px;
        }

        .status-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        .status-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), #8b5cf6, #06b6d4);
        }

        .status-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-indicator.connected {
            background: var(--success);
            box-shadow: 0 0 20px rgba(74, 222, 128, 0.5);
        }

        .status-indicator.disconnected {
            background: var(--error);
            box-shadow: 0 0 20px rgba(248, 113, 113, 0.5);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .status-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .status-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .status-item {
            background: var(--bg-secondary);
            padding: 16px 20px;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .status-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 4px;
        }

        .status-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.95rem;
            color: var(--accent);
        }

        .quotes-section h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quote-count {
            background: var(--accent);
            color: var(--bg-primary);
            font-size: 0.85rem;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .quotes-grid {
            display: grid;
            gap: 20px;
        }

        .quote-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            transition: all 0.3s ease;
            position: relative;
        }

        .quote-card:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .quote-card::before {
            content: '"';
            position: absolute;
            top: 16px;
            left: 24px;
            font-size: 4rem;
            color: var(--accent);
            opacity: 0.15;
            font-family: Georgia, serif;
            line-height: 1;
        }

        .quote-content {
            font-size: 1.15rem;
            line-height: 1.7;
            margin-bottom: 16px;
            padding-left: 8px;
        }

        .quote-author {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            color: var(--accent);
            padding-left: 8px;
        }

        .quote-author::before {
            content: '— ';
            color: var(--text-secondary);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state p {
            margin-bottom: 8px;
        }

        .empty-state code {
            font-family: 'JetBrains Mono', monospace;
            background: var(--bg-secondary);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            color: var(--accent);
        }

        footer {
            text-align: center;
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        footer a {
            color: var(--accent);
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .tech-badges {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        .badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            padding: 6px 14px;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 20px;
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="grid-overlay"></div>
    
    <div class="container">
        <header>
            <div class="logo">
                <div class="logo-icon">🚀</div>
                <h1>Laravel Demo</h1>
            </div>
            <p class="subtitle">PostgreSQL-powered • Deployed on Render</p>
        </header>

        <div class="status-card">
            <div class="status-header">
                <div class="status-indicator {{ $dbStatus['connected'] ? 'connected' : 'disconnected' }}"></div>
                <span class="status-title">
                    Database {{ $dbStatus['connected'] ? 'Connected' : 'Disconnected' }}
                </span>
            </div>
            
            @if($dbStatus['connected'])
                <div class="status-details">
                    <div class="status-item">
                        <div class="status-label">Driver</div>
                        <div class="status-value">{{ $dbStatus['driver'] }}</div>
                    </div>
                    <div class="status-item">
                        <div class="status-label">Database</div>
                        <div class="status-value">{{ $dbStatus['database'] }}</div>
                    </div>
                    <div class="status-item">
                        <div class="status-label">Records</div>
                        <div class="status-value">{{ $quotes->count() }} quotes</div>
                    </div>
                </div>
            @else
                <div class="status-details">
                    <div class="status-item" style="grid-column: 1 / -1;">
                        <div class="status-label">Error</div>
                        <div class="status-value" style="color: var(--error);">{{ $dbStatus['error'] ?? 'Unknown error' }}</div>
                    </div>
                </div>
            @endif
        </div>

        <section class="quotes-section">
            <h2>
                Inspirational Quotes 
                <span class="quote-count">{{ $quotes->count() }}</span>
            </h2>
            
            @if($quotes->count() > 0)
                <div class="quotes-grid">
                    @foreach($quotes as $quote)
                        <article class="quote-card">
                            <p class="quote-content">{{ $quote->content }}</p>
                            <p class="quote-author">{{ $quote->author }}</p>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📝</div>
                    <p>No quotes found in the database.</p>
                    <p>Run <code>php artisan db:seed</code> to populate sample data.</p>
                </div>
            @endif
        </section>

        <footer>
            <p>Built with <a href="https://laravel.com" target="_blank">Laravel</a> • 
               Database powered by <a href="https://www.postgresql.org" target="_blank">PostgreSQL</a> • 
               Hosted on <a href="https://render.com" target="_blank">Render</a></p>
            <div class="tech-badges">
                <span class="badge">PHP {{ PHP_VERSION }}</span>
                <span class="badge">Laravel {{ app()->version() }}</span>
                <span class="badge">PostgreSQL</span>
            </div>
        </footer>
    </div>
</body>
</html>

