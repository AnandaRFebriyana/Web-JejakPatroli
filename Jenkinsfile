pipeline {
  agent any

  environment {
    AUTHOR = "Muhammad Rofiqi"
    PROJECT = "Web-JejakPatroli"
    REPO_URL = "https://github.com/AnandaRFebriyana/Web-JejakPatroli"
  }

  options {
    disableConcurrentBuilds() // Menonaktifkan build concurrent
    timeout(time: 15, unit: 'MINUTES') // Waktu maksimum pipeline
  }

  stages {
    stage("Preparation") {
      steps {
        echo "Preparing build environment for ${PROJECT}"
        echo "Repository URL: ${REPO_URL}"
      }
    }

    stage("Build") {
      steps {
        echo "Start Build"
        
        // Gunakan Docker untuk build aplikasi Node.js
        script {
          sh """
            docker run --rm -v "\${WORKSPACE}:/app" -w /app node:14-alpine /bin/sh -c "npm install && npm run build"
          """
        }
        
        echo "Finish Build"
      }
    }

    stage("Test") {
      steps {
        echo "Start Test"
        
        script {
          sh """
            docker run --rm -v "\${WORKSPACE}:/app" -w /app node:14-alpine /bin/sh -c "npm test || true"
          """
        }
        
        echo "Finish Test"
      }
    }

    stage("Deploy") {
      input {
        message "Can we deploy Web-JejakPatroli?"
        ok "Yes, deploy it"
        submitter "admin"
        parameters {
          choice(name: "TARGET_ENV", choices: ['DEV', 'STAGING', 'PRODUCTION'], description: "Which Environment?")
        }
      }
      steps {
        echo "Deploying ${PROJECT} to ${TARGET_ENV}"
        
        script {
          // Menambahkan logika deployment sesuai dengan target environment
          if (TARGET_ENV == 'PRODUCTION') {
            echo "Deploying to PRODUCTION environment"
            // Tambahkan langkah deploy ke production
            // Misalnya: sh 'scripts/deploy-prod.sh'
          } else if (TARGET_ENV == 'STAGING') {
            echo "Deploying to STAGING environment"
            // Tambahkan langkah deploy ke staging
            // Misalnya: sh 'scripts/deploy-staging.sh'
          } else {
            echo "Deploying to DEV environment"
            // Tambahkan langkah deploy ke development
            // Misalnya: sh 'scripts/deploy-dev.sh'
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
    }
    failure {
      echo "Pipeline for ${PROJECT} failed"
    }
    cleanup {
      echo "Cleaning up workspace"
      deleteDir() // Membersihkan direktori kerja setelah pipeline selesai
    }
  }
}
