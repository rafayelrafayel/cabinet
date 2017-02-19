# AngularJS Contact List Application





### Node.js and Tools

- Get [Node.js][node-download].
- Install the tool dependencies (`npm install`).




## Development with angular-contact list

The following docs describe how you can test  this application.


### Installing dependencies

The application relies upon various node.js tools, such as Bower, Karma and Protractor.  You can
install these by running:

```
npm install
```





### Running the app during development

- Run your server
- navigate your browser to `http://localhost/task/app` to see the app running in your browser.

### Running unit tests

 [Jasmine][jasmine] and [Karma][karma] for unit testing

- Start Karma with `node node_modules/karma/bin/karma start test/karma.conf.js`
  - A browser will start and connect to the Karma server. Chrome is the default browser.
- Karma will sit, watch and test JavaScript files. To run or re-run tests just
  change any of your these files.


### End to end testing

 [Jasmine][jasmine] and [Protractor][protractor] for end-to-end testing.

 -Use npm to install Protractor globally with: `npm install -g protractor`
 -Use [webdriver-manager] to download the necessary binaries with:`webdriver-manager update`
 -Now start up a server with:`webdriver-manager start`

 Requires a webserver that serves the application. 
 Start Protractor with `protractor test/protractor-conf.js`

 - The configuration is set up to run the tests on Chrome directly.



## Application Directory Layout

    app/                --> all of the files to be used in production
      css/              --> css files
        app.css         --> default stylesheet
     
      index.html        --> app layout file (the main html template file of the app)
      js/               --> javascript files
        app.js          --> the main application module
        controllers.js  --> application controllers
        directives.js   --> application directives
        filters.js      --> custom angular filters
        services.js     --> custom angular services
        providers.js     --> custom angular providers
        animations.js   --> hooks for running JQuery animations with ngAnimate
      partials/         --> angular view partials (partial html templates) used by ngRoute
        _form.html
        contacts-add.html
        contacts-edit.html
        contacts-list.html
      bower_components  --> 3rd party js libraries, including angular and jquery
      views/ --> angular view templates 
        directives --> view templates for directives

   
    test/               --> test source files and libraries
      karma.conf.js        --> config file for running unit tests with Karma
      protractor-conf.js   --> config file for running e2e tests with Protractor
      e2e/
        scenarios.js       --> end-to-end specs
      unit/             --> unit level specs/tests
        controllers-Spec.js --> specs for controllers
        



