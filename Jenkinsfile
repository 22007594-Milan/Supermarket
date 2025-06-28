pipeline {
    agent any

    stages {
        stage('Clone Repository') {
            steps {
                echo 'Cloning from GitHub...'
                git branch: 'main',
                    url: 'https://github.com/NivethLegend/supermarket-FYP.git',
                    credentialsId: 'github-creds'
            }
        }

        stage('Build') {
            steps {
                echo '✅ Build stage running...'
                // Add build commands here later (e.g., composer install, npm build)
            }
        }

        stage('Test') {
            steps {
                echo '✅ Test stage running...'
                // Placeholder for future tests
            }
        }
    }

    post {
        failure {
            echo '❌ Pipeline failed. Check logs above.'
        }
        success {
            echo '✅ Pipeline succeeded!'
        }
    }
}



