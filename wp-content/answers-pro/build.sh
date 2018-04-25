#!/bin/bash

# 1 - project absolute path


DATE=`date +"%Y%m%d%H%M%S"`
NAME="cm-answers-pro"
WORKSPACE=`pwd`
LICENSING="$WORKSPACE/../git/cm-package"

# Update licensing package
cp $LICENSING/pro/* $1/package -R


# ---------------------------------------------------
# Create a directory and clean it

cp -R "$1" "$NAME"
rm -R "$NAME/.settings"
rm -R "$NAME/.project"
rm -R "$NAME/.buildpath"
rm -R "$NAME/.externalToolBuilders"
rm -R "$NAME/build.sh"

# ---------------------------------------------------
# Prepare the PRO version

zip -r "$NAME-$DATE-robert.zip" "$NAME"

# ---------------------------------------------------
# Clean

rm -R "$NAME"

echo "Done."
