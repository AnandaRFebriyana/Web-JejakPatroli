pipeline {
    agent any
    
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        
        stage('Setup Environment') {
            steps {
                sh 'cp .env.example .env'
                sh 'sed -i "s/DB_HOST=127.0.0.1/DB_HOST=mysql/g" .env'
                sh 'sed -i "s/DB_DATABASE=laravel/DB_DATABASE=jejakpatroli/g" .env'
                sh 'sed -i "s/DB_USERNAME=root/DB_USERNAME=root/g" .env'
                sh 'sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=/g" .env'
            }
        }
        
        stage('Install Dependencies') {
            steps {
                sh 'docker run --rm -v $(pwd):/app composer:latest composer install --no-interaction'
            }
        }
        
        stage('Generate Key') {
            steps {
                sh 'docker run --rm -v $(pwd):/app -w /app php:8.1-cli php artisan key:generate'
            }
        }
        
        stage('Run Tests') {
            steps {
                sh 'docker run --rm -v $(pwd):/app -w /app php:8.1-cli vendor/bin/phpunit --log-junit tests/results/results.xml || true'
            }
            post {
                always {
                    junit 'tests/results/results.xml'
                }
            }
        }
        
        stage('Deploy to Production') {
            when {
                branch 'main'
            }
            steps {
                sh 'mkdir -p nginx/conf.d'
                sh 'echo "server { listen 80; server_name _; root /var/www/public; add_header X-Frame-Options \\"SAMEORIGIN\\"; add_header X-XSS-Protection \\"1; mode=block\\"; add_header X-Content-Type-Options \\"nosniff\\"; index index.php; charset utf-8; location / { try_files \\$uri \\$uri/ /index.php?\\$query_string; } location = /favicon.ico { access_log off; log_not_found off; } location = /robots.txt  { access_log off; log_not_found off; } error_page 404 /index.php; location ~ \\.php$ { fastcgi_pass app:9000; fastcgi_param SCRIPT_FILENAME \\$realpath_root\\$fastcgi_script_name; include fastcgi_params; } location ~ /\\.(?!well-known).* { deny all; } }" > nginx/conf.d/app.conf'
                sh 'docker-compose down || true'
                sh 'docker-compose up -d --build'
                sh 'docker exec jejakpatroli-app php artisan migrate --force'
            }
        }
        
        stage('Setup Monitoring') {
            when {
                branch 'main'
            }
            steps {
                sh 'docker run --rm -d -p 3000:3000 --name grafana grafana/grafana-oss'
                sh 'docker run --rm -d -p 9090:9090 --name prometheus prom/prometheus'
            }
        }
    }
    
    post {
        always {
            echo 'Pipeline completed'
        }
        success {
            echo 'Pipeline succeeded'
        }
        failure {
            echo 'Pipeline failed'
        }
    }
}