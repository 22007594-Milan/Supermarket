pipeline {
    agent any

    stages {
        stage('Clone Repository') {
            steps {
                echo 'Cloning from GitHub...'
                git url: 'https://github.com/NivethLegend/supermarket-FYP.git', credentialsId: 'github-creds'
            }
        }

        stage('Build') {
            steps {
                echo 'Building application...'
                // Example build step
                sh 'echo Simulating build process'
            }
        }

        stage('Test') {
            steps {
                echo 'Running basic tests...'
                // Example test step
                sh 'echo All tests passed!'
            }
        }
    }

    post {
        success {
            echo '✅ Pipeline finished successfully.'
        }
        failure {
            echo '❌ Pipeline failed. Check logs above.'
        }
    }
}


