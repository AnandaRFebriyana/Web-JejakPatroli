pipeline {
  agent {
    docker {
      image 'php:8.1-fpm' // Use a PHP-based image with Node.js installed
      args '-v $HOME/.npm:/root/.npm -v $HOME/.composer:/root/.composer'
    }
  }
  environment {
    AUTHOR = "Muhammad Rofiqi"
    PROJECT = "Web-JejakPatroli"
    REPO_URL = "https://github.com/AnandaRFebriyana/Web-JejakPatroli"
    DEPLOY_DIR = "/var/www/jejakpatroli"
    DEPLOY_USER = "www-data"
    DEPLOY_GROUP = "www-data"
    COMPOSER_ALLOW_SUPERUSER = "1" // Allow Composer to run as root in Docker
  }
  options {
    disableConcurrentBuilds()
    timeout(time: 15, unit: 'MINUTES')
  }
  stages {
    stage("Preparation") {
      steps {
        echo "Preparing build environment for ${PROJECT}"
        echo "Repository URL: ${REPO_URL}"
        // Install Node.js and npm in the PHP image
        sh '''
          apt-get update && apt-get install -y nodejs npm
          node --version
          npm --version
        '''
      }
    }
    stage("Build") {
      steps {
        echo "Starting Build"
        sh "npm ci && npm run build" // Use npm ci for consistent installs
        echo "Finished Build"
      }
    }
    stage("Test") {
      steps {
        echo "Starting Test"
        sh "npm test" // Remove || true to fail on test errors
        echo "Finished Test"
      }
    }
    stage("Deploy") {
      steps {
        echo "Deploying ${PROJECT} to ${TARGET_ENV}"
        script {
          // Prompt for deployment approval
          input message: "Can we deploy Web-JejakPatroli?",
                ok: "Yes, deploy it",
                submitter: "admin",
                parameters: [
                  choice(name: "TARGET_ENV", choices: ['DEV', 'STAGING', 'PRODUCTION'], description: "Which Environment?")
                ]

          // Define environment-specific settings
          def envDir = "${DEPLOY_DIR}/${TARGET_ENV.toLowerCase()}"
          def symlink = "${DEPLOY_DIR}/${TARGET_ENV.toLowerCase()}-current"
          def envFile = TARGET_ENV == 'PRODUCTION' ? '.env.production' :
                        TARGET_ENV == 'STAGING' ? '.env.staging' : '.env.dev'

          // Ensure deployment directory exists
          sh "mkdir -p ${envDir}"

          // Copy workspace files to deployment directory
          sh "cp -R ${WORKSPACE}/* ${envDir}/"

          // Run Laravel-specific commands
          dir("${envDir}") {
            // Copy or create .env file (assumes .env files are in repo or provided via secrets)
            sh """
              if [ -f ${envFile} ]; then
                cp ${envFile} .env
              else
                echo "Warning: ${envFile} not found, using default .env or manual configuration required"
                touch .env
              fi
            """

            // Install PHP dependencies
            sh "composer install ${TARGET_ENV == 'PRODUCTION' ? '--no-dev --optimize-autoloader' : '--optimize-autoloader'}"

            // Generate application key
            sh "php artisan key:generate --force"

            // Run migrations
            sh "php artisan migrate --force"

            // Optimize for environment
            if (TARGET_ENV == 'PRODUCTION' || TARGET_ENV == 'STAGING') {
              sh '''
                php artisan config:cache
                php artisan route:cache
                php artisan view:cache
              '''
            } else {
              sh '''
                php artisan config:clear
                php artisan route:clear
                php artisan view:clear
                php artisan cache:clear
              '''
            }

            // Set permissions
            sh """
              chown -R ${DEPLOY_USER}:${DEPLOY_GROUP} .
              chmod -R 755 .
              chmod -R 775 storage bootstrap/cache
            """
          }

          // Update symlink
          sh "ln -sfn ${envDir} ${symlink}"

          // Restart services (check if systemctl is available)
          sh '''
            if command -v systemctl >/dev/null 2>&1; then
              systemctl restart nginx || echo "Failed to restart nginx"
              systemctl restart php-fpm || echo "Failed to restart php-fpm"
            else
              echo "Systemctl not available, skipping service restart"
            fi
          '''
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
    }
    failure {
      echo "Pipeline for ${PROJECT} failed"
    }
    cleanup {
      echo "Cleaning up workspace"
      // Uncomment if workspace cleanup is desired
      // cleanWs()
    }
  }
}
