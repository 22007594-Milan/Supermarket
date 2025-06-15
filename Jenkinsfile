pipeline {
    agent any

    environment {
        GIT_URL = 'https://github.com/NivethLegend/supermarket-FYP.git'
        GIT_CREDENTIALS = 'github-creds'
    }

    stages {
        stage('Clone Repo') {
            steps {
                script {
                    withCredentials([string(credentialsId: "${GIT_CREDENTIALS}", variable: 'GITHUB_TOKEN')]) {
                        sh '''
                            rm -rf supermarket-FYP
                            git clone https://NivethLegend:${GITHUB_TOKEN}@github.com/NivethLegend/supermarket-FYP.git
                        '''
                    }
                }
            }
        }

        stage('Build') {
            steps {
                dir('supermarket-FYP') {
                    sh 'echo "Running build..."'
                }
            }
        }

        stage('Test') {
            steps {
                dir('supermarket-FYP') {
                    sh 'echo "Running tests..."'
                }
            }
        }
    }
}

