pipeline {
    agent any

    environment {
        GIT_CREDENTIALS_ID = 'github-creds'  // Make sure this exists in Jenkins credentials
    }

    stages {
        stage('Clone Repository') {
            steps {
                echo '📥 Cloning repository from GitHub...'
                git url: 'https://github.com/NivethLegend/supermarket-FYP.git', credentialsId: "${GIT_CREDENTIALS_ID}"
            }
        }

        stage('Build') {
            steps {
                echo '🔧 Building the application...'
                // Add actual build commands if needed
            }
        }

        stage('Testing') {
            parallel {
                stage('SonarScanner Test') {
                    steps {
                        echo '🔍 Running SonarScanner test...'
                        // sh 'sonar-scanner'  // Uncomment if SonarQube is configured
                    }
                }
                stage('Dummy API Test') {
                    steps {
                        echo '✅ Dummy API test passed.'
                    }
                }
            }
        }

        stage('Approval Gatekeeper') {
            steps {
                script {
                    input message: '🛑 Manual approval required before deploying to production.', ok: '✅ Approve'
                }
            }
        }

        stage('Deploy to Production') {
            steps {
                echo '🚀 Deploying application to production environment...'
                // You can add docker-compose up or rsync/ssh deploy commands here
            }
        }
    }

    post {
        success {
            echo '🎉 Pipeline completed successfully.'
        }
        failure {
            echo '❌ Pipeline failed. Please check the logs.'
        }
    }
}




