pipeline {
    agent any

    environment {
        PROD_HOST = 'root@141.11.190.114'
        SSH_CREDENTIALS = credentials('ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQDxX/Cf6OdDoPzXZ0nxfDcaRwUqyBj2634cHY1wJ7UH5W8CQuqmJbQ3UmhCypTV7t5rm7MCNoRc30k4m7lCAsyCPsGNgOl3FsNE0YgsgWjxxLeI1J2Z1Wd8gYGuDp0WLtfS0wRd7LYnZcbrJVa4DKl0ZRuGQpiRO1HH/PY17nbzqHeO6hfRrW0hw1pGelm3p+XE51CpZNSVMG6gQqjSfxGX0X7J0qHasJg/kH8Y/ym1z2mhazlFTA3QxGr7rqF6QQP2+fzpK4AWBMrJInvwVjcX1rW+ntzn6hwxjXUDbrdn36B64CXqHNOAZ7v8v6O2/oa10SOay+yxnA4gzPx3Z34FXF+/olNeVnBFkGKQPZo+KSO7RkXx1qh8lXS6UEV75aFkro4RL8EI+8rRQS2gqEw3g0Lfzuj64TyRAeuU6SElkCrnsLjUnAujkc6Ra8q5CXvBP/mrb/IInFoSMt2emwu2hG69oEer5CdwNYBZFKbhOVk2zcdUFy8kF2QUOSyZsGlLlDgWUIpZT8rR6fpPBIVpGStKVFv+LS8Oh47yqjgqquA4KahOPhXU5A6SLIwjCMxiviHv8bUae0ccPMnREDO6nIqJ5EpH0Y8bW+kGQxrCYIRpVH42esWzDCv4trk2r96WlhB42TDo7hWRHfh/jM3ftu1ncIYT1MkylOMBYpNljw== rofiqimuhammad437@gmail.com
')     // Sesuai dengan ID credentials di Jenkins
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scmGit(
                    branches: [[name: 'main']],
                    userRemoteConfigs: [[url: 'https://github.com/AnandaRFebriyana/Web-JejakPatroli']]
                )
            }
        }

        stage('Build') {
            steps {
                script {
                    echo 'Building application...'
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    echo 'Running tests...'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    echo 'Deploying application...'
                }

                sshagent (credentials: [SSH_CREDENTIALS]) {
                    sh 'mkdir -p ~/.ssh'
                    sh 'ssh-keyscan -H "$PROD_HOST" >> ~/.ssh/known_hosts'

                    // Copy project files ke server menggunakan rsync
                    sh '''
                    rsync -rav --delete ./ ubuntu@$PROD_HOST:/home/ubuntu/prod.kelasdevops.xyz/ \
                    --exclude=.env --exclude=storage --exclude=.git
                    '''
                }
            }
        }
    }
}
