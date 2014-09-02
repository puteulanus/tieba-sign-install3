#!/bin/sh

php "${OPENSHIFT_REPO_DIR}do.php" || ( echo 'Cron task failed.' >&2 )

