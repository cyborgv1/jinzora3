echo "Enter owners name for file permissions: "
read own_name
echo "Enter group apache runs undre for file permissions: "
echo "This is usually www-data on debian systems"
read apache_group

chown -R $own_name:$apache_group *
chown $own_name:$apache_group .*
find -type d -print0 | xargs -0 chmod 550
find -type f -print0 | xargs -0 chmod 440

if [ ! -f settings.php ]; then
	touch settings.php
fi

chmod -R 770 data/ temp/ services/services/players/flvplayer/temp/
chmod 660 settings.php
chmod 660 jukebox/settings.php
chmod 550 permissions.sh

echo ""
echo "Permissions have been set and you are now ready to setup Jinzora."
echo "Please direct your web browser to the directory where you installed Jinzora"
echo "and load index.php - you will then be taken through the complete setup"
echo ""
echo ""
