tieba-sign-install3
===================

Tieba Cloud Sign is a multiuser website to help users sign in automatically every day to get reward from Tieba.It's a extendible,user-friendly platform.Administrator can add functions by installing plugins.The wenbiste won't save the passwords of users,it use cookies and work well.
This git repository helps you get up and running quickly with a Tieba Cloud Sign installation on OpenShift. The backend database is MySQL and the database name is the same as your application name (using getenv('OPENSHIFT_APP_NAME')). You can name your application whatever you want. However, the name of the database will always match the application so you might have to update .openshift/action_hooks/build.

##Running on OpenShift

Create an account at https://www.openshift.com and install the client tools (run 'rhc setup' first)

Create a php-5.4 application (you can call your application whatever you want)

`rhc app create sign php-5.4 mysql-5.5 cron-1.4 --from-code=https://github.com/puteulanus/tieba-sign-install3`

That's it, you can now checkout your application at:

`http://sign-$yournamespace.rhcloud.com`

You'll be prompted to set an admin password the first time you visit this page.If you use the plus or plusplus branch,please chage the default password for KODExplorer as soon as possible.

Note: When you upload plugins and themes, they'll get put into your OpenShift data directory on the gear ($OPENSHIFT_DATA_DIR). If you'd like to check these into source control, download the plugins and themes directories and then check them directly into plugins.

##Security Considerations

Consult the Tieba Cloud Sign documentation for best practices regarding securing your Tieba Cloud Sign installation. OpenShift automatically generates unique secret keys for your deployment into config.php, but you may feel more comfortable following the Tieba Cloud Sign documentation directly.
