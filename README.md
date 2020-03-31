# Readme



## Setup Development Environment

To create a development environment use

    docker-compose up
    
Afterwards visit http://localhost:8080

## Auto release (new way)

1) Checkout your feature(bugfix) branch
```bash
git checkout feature-branch
```

2) Delete local copy of the deploy-to-production branch
```bash
git branch -d deploy-to-production
```

3) Create new local deploy-to-production branch from the feature branch
```bash
git checkout -b deploy-to-production
```

4) Push new deploy-to-production branch
```bash
git push --set-upstream origin deploy-to-production -f
```

Push event on `deploy-to-production` branch will trigger github action and:

 - code is checked out from github (with new feature for the plugin)
 - code is checked out from svn (current release system of wordpress)
 - old code from trunk is replaced with the new one from github
 - new tag version is taken from readme.txt (line with => Stable tag: X.Y.Z)
 - new tag is created
 - all code is pushed to svn


## Manual release (old way)

1) Checkout the existing version from wordpress
    ```bash
    mkdir resmio-button-and-widget
    
    svn co https://plugins.svn.wordpress.org/resmio-button-and-widget resmio-button-and-widget
    ```

2) Adjust whatever you want in `trunk`

3) Create a new version folder in the `tags` sub directory, e.g 1.3

4) Copy everything from trunk to that new version directory

5) Commit and push everything to svn
```bash
svn ci -m 'Some Message' --username Philipp-resmio --password PasswordFromLastPass
```




One can check out the official instructions here:

https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/