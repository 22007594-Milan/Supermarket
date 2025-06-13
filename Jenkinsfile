pipeline {
    agent any

    stages {
        stage('Clone Repo') {
            steps {
                git url: 'https://github.com/NivethLegend/supermarket-FYP.git', credentialsId: 'github-creds'
            }
        }

        stage('Build') {
            steps {
                echo 'Building the application...'
            }
        }

        stage('SonarQube Test') {
            steps {
                echo 'Running SonarScanner...'
            }
        }

        stage('Dummy API Test') {
            steps {
                echo 'Dummy API test passed.'
            }
        }
    }
}
