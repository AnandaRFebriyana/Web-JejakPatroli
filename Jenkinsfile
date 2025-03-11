node { 
    checkout scm 

    // deploy env dev 
    stage("Build") { 
        docker.image('shippingdocker/php-composer:7.4').inside('-u root') { 
            sh 'rm composer.lock' 
            sh 'composer install' 
        } 
    } 

    // Testing 
    stage("Test") {  // Tambahkan stage untuk testing agar lebih rapi
        docker.image('ubuntu').inside('-u root') { 
            sh 'echo "Ini adalah test"' 
        } 
    }
}
