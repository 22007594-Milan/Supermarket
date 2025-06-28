pipeline {
    agent any

    stages {
        stage('Clone Repository') {
            steps {
                echo '📦 Cloning from GitHub...'
                git branch: 'main',
                    url: 'https://github.com/NivethLegend/supermarket-FYP.git',
                    credentialsId: 'github-creds'
            }
        }

        stage('Build') {
            steps {
                echo '🔧 Running build steps...'
                // Add your build steps like composer install or npm install
            }
        }

        stage('Test') {
            parallel {
                stage('SonarQube Scan') {
                    steps {
                        echo '🔍 Running SonarQube scan (placeholder)...'
                        // sonar-scanner CLI command goes here
                    }
                }
                stage('Dummy API Test') {
                    steps {
                        echo '🧪 Running dummy API test...'
                        // curl or echo "API test" command here
                    }
                }
            }
        }

        stage('Gatekeeper Approval') {
            steps {
                script {
                    input message: '✅ Approve to deploy to production?', ok: 'Approve Deployment'
                }
            }
        }

        stage('Deploy') {
            steps {
                echo '🚀 Deploying application...'
                // Your docker-compose or deployment script here
            }
        }
    }

    post {
        success {
            echo '✅ Pipeline completed successfully.'
        }
        failure {
            echo '❌ Pipeline failed.'
        }
    }
}


