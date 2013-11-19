#!/bin/bash
GITNAME=$1
GROUPNAME=$2
GITDIR="/var/git/$GITNAME.git"
GITFILECONFIG="/etc/httpd/conf.d/git/$GITNAME.conf"
GITVIEWCONFIG="/etc/httpd/conf.d/gitview/$GITNAME.conf"

if [ ! -f "$GITFILECONFIG" ]; then
touch $GITFILECONFIG
cat <<-END >>$GITFILECONFIG
#<Location /$GITNAME.git>
<LocationMatch /$GITNAME.git/*/git-receive-pack%">
#    Deny from All
#    DAV on

    AuthType Basic
    AuthName "Authorize for use $GITNAME!  Please use TRUELIFE Domain for login                                                                                         access."
    AuthBasicProvider ldap
    AuthzLDAPAuthoritative On
    AuthLDAPUrl "ldap://10.1.17.2:389/ou=IT,dc=truelife,dc=th?sAMAccountName?sub                                                                                        ?(objectClass=*)"
    AuthLDAPBindDN "ldapsearch@truelife.th"
    AuthLDAPBindPassword P@ssw0rd
    AuthLDAPGroupAttributeIsDN On
    AuthLDAPGroupAttribute Member

    Require ldap-group cn=$GROUPNAME,ou=REPO,ou=GROUPS,dc=truelife,dc=th

#    Satisfy any
    Options FollowSymLinks -MultiViews Indexes ExecCGI
</LocationMatch>
#</Location>
END
fi

if [ ! -f "$GITVIEWCONFIG" ]; then
touch $GITVIEWCONFIG
cat <<-END >>$GITVIEWCONFIG
<Location /projects/$GITNAME.git>
    Deny from All

    AuthType Basic
    AuthName "Authorize for use $GITNAME!  Please use TRUELIFE Domain for login                                                                                         access."
    AuthBasicProvider ldap
    AuthzLDAPAuthoritative On
    AuthLDAPUrl "ldap://10.1.17.2:389/ou=IT,dc=truelife,dc=th?sAMAccountName?sub                                                                                        ?(objectClass=*)"
    AuthLDAPBindDN "ldapsearch@truelife.th"
    AuthLDAPBindPassword P@ssw0rd
    AuthLDAPGroupAttributeIsDN On
    AuthLDAPGroupAttribute Member

    Require ldap-group cn=$GROUPNAME,ou=REPO,ou=GROUPS,dc=truelife,dc=th

    Satisfy any
    Options FollowSymLinks -MultiViews Indexes ExecCGI
</Location>
END

#service httpd restart
sleep 3
sudo /usr/sbin/httpd -k graceful

fi

if [ ! -d "$GITDIR" ]; then
   mkdir $GITDIR
   cd $GITDIR
   sudo /usr/bin/git --bare init
   sudo /bin/chown -R apache.apache $GITDIR
fi

