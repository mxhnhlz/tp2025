<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Подтверждение регистрации - CyberSafe Trainer</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 20px;
            color: #1e293b;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 16px;
            color: #475569;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .button-container {
            text-align: center;
            margin: 40px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
        }
        .footer {
            background: #f8fafc;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            color: #64748b;
        }
        .warning {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 15px 20px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }
        .warning strong {
            color: #dc2626;
        }
        .info-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }
        .info-box strong {
            color: #0369a1;
        }
        .token {
            font-family: 'Courier New', monospace;
            background: #f1f5f9;
            padding: 10px 15px;
            border-radius: 6px;
            display: inline-block;
            margin: 10px 0;
            color: #0f172a;
            font-weight: 600;
        }
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .logo-text {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 25px 15px;
            }
            .header h1 {
                font-size: 24px;
            }
            .button {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <div class="logo-text">CyberSafe Trainer</div>
        </div>
        <h1>Подтверждение регистрации</h1>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="greeting">Здравствуйте, {{ $pendingUser->name }}!</div>

        <div class="message">
            Спасибо за регистрацию на платформе <strong>CyberSafe Trainer</strong> — интерактивном симуляторе кибербезопасности.
        </div>

        <div class="info-box">
            <p><strong>Для завершения регистрации</strong> и активации вашего аккаунта, нажмите на кнопку ниже:</p>
        </div>

        <!-- Кнопка подтверждения -->
        <div class="button-container">
            <a href="{{ url('/verify-email/'.$pendingUser->token) }}" class="button">
                ✅ Подтвердить мою регистрацию
            </a>
        </div>

        <!-- Альтернативная ссылка -->
        <div style="text-align: center; margin: 20px 0;">
            <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">
                Или скопируйте и вставьте эту ссылку в браузер:
            </p>
            <div class="token">
                {{ url('/verify-email/'.$pendingUser->token) }}
            </div>
        </div>

        <!-- Предупреждение -->
        <div class="warning">
            <p><strong>⚠️ Важно:</strong> Ссылка действительна в течение 24 часов.</p>
            <p>Если вы не завершите регистрацию в течение этого времени, вам потребуется зарегистрироваться заново.</p>
        </div>

        <div class="message">
            После подтверждения email вы получите полный доступ ко всем функциям платформы:
            <ul style="margin: 15px 0; padding-left: 20px;">
                <li>Интерактивные разделы обучения</li>
                <li>Практические задания по кибербезопасности</li>
                <li>Отслеживание прогресса и достижений</li>
                <li>Сертификаты об успешном прохождении курсов</li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>
            <strong>Если вы не регистрировались на CyberSafe Trainer</strong>, просто проигнорируйте это письмо.
            Ваши данные будут автоматически удалены через 24 часа.
        </p>
        <p style="margin-top: 20px; font-size: 13px; color: #94a3b8;">
            Это письмо было отправлено автоматически. Пожалуйста, не отвечайте на него.<br>
            © 2024 CyberSafe Trainer. Все права защищены.
        </p>
    </div>
</div>
</body>
</html>
