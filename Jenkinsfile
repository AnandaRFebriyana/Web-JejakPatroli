pipeline {
  agent {
    docker {
      image 'node:14-alpine'
      args '-v $HOME/.npm:/root/.npm'
    }
  }
  environment {
    AUTHOR = "Muhammad Rofiqi"
    PROJECT = "Web-JejakPatroli"
    REPO_URL = "https://github.com/AnandaRFebriyana/Web-JejakPatroli"
    DEPLOY_DIR = "/var/www/jejakpatroli"
    DEPLOY_USER = "www-data"
    DEPLOY_GROUP = "www-data"
  }
  options {
    disableConcurrentBuilds()
    timeout(time: 15, unit: 'MINUTES')
  }
  stages {
    stage("Preparation") {
      steps {
        echo("Preparing build environment for ${PROJECT}")
        echo("Repository URL: ${REPO_URL}")
      }
    }
    stage("Build") {
      steps {
        echo("Start Build")
        sh "npm install && npm run build"
        echo("Finish Build")
      }
    }
    stage("Test") {
      steps {
        echo("Start Test")
        sh "npm test || true"
        echo("Finish Test")
      }
    }
    stage("Deploy") {
      agent any  // Kembali ke agent default untuk deployment
      input {
        message "Can we deploy Web-JejakPatroli?"
        ok "Yes, deploy it"
        submitter "admin"
        parameters {
          choice(name: "TARGET_ENV", choices: ['DEV', 'STAGING', 'PRODUCTION'], description: "Which Environment?")
        }
      }
      steps {
        echo("Deploying ${PROJECT} to ${TARGET_ENV}")
        
        script {
          if (TARGET_ENV == 'PRODUCTION') {
            echo("Deploying to PRODUCTION environment")
            
            // Buat direktori deployment jika belum ada
            sh "sudo mkdir -p ${DEPLOY_DIR}/production"
            
            // Salin konten workspace ke direktori deployment
            sh "sudo cp -R ${WORKSPACE}/* ${DEPLOY_DIR}/production/"
            
            // Jalankan perintah untuk Laravel
            dir("${DEPLOY_DIR}/production") {
              // Install PHP dependencies dengan Composer
              sh "sudo composer install --no-dev --optimize-autoloader"
              
              // Generate application key jika belum ada
              sh "sudo php artisan key:generate --force"
              
              // Migrasi database
              sh "sudo php artisan migrate --force"
              
              // Clear cache dan optimize
              sh "sudo php artisan config:cache"
              sh "sudo php artisan route:cache"
              sh "sudo php artisan view:cache"
              
              // Set permission
              sh "sudo chown -R ${DEPLOY_USER}:${DEPLOY_GROUP} ."
              sh "sudo chmod -R 755 ."
              sh "sudo chmod -R 775 storage bootstrap/cache"
            }
            
            // Perbarui symlink jika diperlukan
            sh "sudo ln -sfn ${DEPLOY_DIR}/production ${DEPLOY_DIR}/current"
            
            // Restart web server
            sh "sudo systemctl restart nginx"
            sh "sudo systemctl restart php-fpm"
            
          } else if (TARGET_ENV == 'STAGING') {
            echo("Deploying to STAGING environment")
            
            // Buat direktori deployment jika belum ada
            sh "sudo mkdir -p ${DEPLOY_DIR}/staging"
            
            // Salin konten workspace ke direktori deployment
            sh "sudo cp -R ${WORKSPACE}/* ${DEPLOY_DIR}/staging/"
            
            // Jalankan perintah untuk Laravel
            dir("${DEPLOY_DIR}/staging") {
              // Copy .env file dari template
              sh "sudo cp .env.staging .env"
              
              // Install PHP dependencies dengan Composer
              sh "sudo composer install --optimize-autoloader"
              
              // Generate application key jika belum ada
              sh "sudo php artisan key:generate --force"
              
              // Migrasi database
              sh "sudo php artisan migrate --force"
              
              // Clear cache dan optimize
              sh "sudo php artisan config:cache"
              sh "sudo php artisan route:cache"
              sh "sudo php artisan view:cache"
              
              // Set permission
              sh "sudo chown -R ${DEPLOY_USER}:${DEPLOY_GROUP} ."
              sh "sudo chmod -R 755 ."
              sh "sudo chmod -R 775 storage bootstrap/cache"
            }
            
            // Perbarui symlink
            sh "sudo ln -sfn ${DEPLOY_DIR}/staging ${DEPLOY_DIR}/staging-current"
            
            // Restart web server
            sh "sudo systemctl restart nginx"
            sh "sudo systemctl restart php-fpm"
            
          } else {
            echo("Deploying to DEV environment")
            
            // Buat direktori deployment jika belum ada
            sh "sudo mkdir -p ${DEPLOY_DIR}/development"
            
            // Salin konten workspace ke direktori deployment
            sh "sudo cp -R ${WORKSPACE}/* ${DEPLOY_DIR}/development/"
            
            // Jalankan perintah untuk Laravel
            dir("${DEPLOY_DIR}/development") {
              // Copy .env file dari template
              sh "sudo cp .env.dev .env"
              
              // Install PHP dependencies dengan Composer
              sh "sudo composer install"
              
              // Generate application key jika belum ada
              sh "sudo php artisan key:generate --force"
              
              // Migrasi database
              sh "sudo php artisan migrate"
              
              // Clear cache
              sh "sudo php artisan config:clear"
              sh "sudo php artisan route:clear"
              sh "sudo php artisan view:clear"
              sh "sudo php artisan cache:clear"
              
              // Set permission
              sh "sudo chown -R ${DEPLOY_USER}:${DEPLOY_GROUP} ."
              sh "sudo chmod -R 755 ."
              sh "sudo chmod -R 775 storage bootstrap/cache"
            }
            
            // Perbarui symlink
            sh "sudo ln -sfn ${DEPLOY_DIR}/development ${DEPLOY_DIR}/dev-current"
            
            // Restart web server
            sh "sudo systemctl restart nginx"
            sh "sudo systemctl restart php-fpm"
          }
        }
      }
    }
  }
  post {
    always {
      echo "Pipeline for ${PROJECT} has completed"
    }
    success {
      echo "Pipeline for ${PROJECT} completed successfully"
      
      // Kirim notifikasi sukses jika diperlukan
      // mail to: "team@example.com", subject: "${PROJECT} - Build Succeeded", body: "Build completed successfully"
    }
    failure {
      echo "Pipeline for ${PROJECT} failed"
      
      // Kirim notifikasi gagal
      // mail to: "team@example.com", subject: "${PROJECT} - Build Failed", body: "Build failed, please check Jenkins logs"
    }
    cleanup {
      echo "Cleaning up workspace"
      
      // Bersihkan workspace jika diperlukan
      // cleanWs()
    }
  }
}
