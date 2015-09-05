#!/bin/bash

PKG_NAME=siteaccess
PKG_PATH=/tmp/${PKG_NAME}.out
VER_MAJOR=2
VER_MINOR=4
VER_REV=$(cat version.txt)

if [[ -d "${PKG_PATH}" ]]; then
    rm -rf "${PKG_PATH}"
fi
mkdir -p ${PKG_PATH}
git archive --format=tar --prefix="${PKG_NAME}"/ HEAD | tar Cxf "${PKG_PATH}" -
((VER_REV++))
sed -i "" -e "s/VER_MAJOR/${VER_MAJOR}/g;s/VER_MINOR/${VER_MINOR}/g;s/VER_REV/${VER_REV}/g" ${PKG_PATH}/${PKG_NAME}/manifest.xml
echo "${VER_REV}" > version.txt
git add version.txt
git commit -m "pkg tag ${VER_MAJOR}.${VER_MINOR}.${VER_REV}"
git tag "${VER_MAJOR}.${VER_MINOR}.${VER_REV}"
git push --all
git push --tags

cd "${PKG_PATH}"
zip -r "/tmp/${PKG_NAME}-${VER_MAJOR}.${VER_MINOR}.${VER_REV}.zip" ${PKG_NAME}
