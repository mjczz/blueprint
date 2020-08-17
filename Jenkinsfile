pipeline {
    agent { docker 'php' }
    stages {
        stage('build') {
            steps {
                sh 'php --version'
                 sh 'echo "Hello World"'
                 sh '''
                    echo "Multiline shell steps works too"
                    ls -lah
                 '''
            }
        }
    }
}
