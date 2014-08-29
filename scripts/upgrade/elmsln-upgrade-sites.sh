#!/bin/bash
#where am i? move to where I am. This ensures source is properly sourced
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

source ../../config/scripts/drush-create-site/config.cfg

#provide messaging colors for output to console
txtbld=$(tput bold)             # Bold
bldgrn=${txtbld}$(tput setaf 2) #  green
bldred=${txtbld}$(tput setaf 1) #  green
txtreset=$(tput sgr0)
elmslnecho(){
  echo "${bldgrn}$1${txtreset}"
  return 1
}
elmslnwarn(){
  echo "${bldred}$1${txtreset}"
  return 1
}
# Define seconds timestamp
timestamp(){
  date +"%s"
}

#test for empty vars. if empty required var -- exit
if [ -z $elmsln ]; then
  elmslnwarn "please update your config.cfg file"
  exit 1
fi
if [ -z $host ]; then
  elmslnwarn "please update your config.cfg file"
  exit 1
fi
if [ -z $1 ]; then
  elmslnwarn "please select a branch you want to update too (like master)"
  exit 1
fi

# allow for lazy, dangerous people like btopro who enter yes via commandline
if [ -z $2 ]; then
  elmslnecho "Are you sure you want to upgrade the entire network? (Type yes)"
  read yesprompt
else
  yesprompt=$2
fi
# ensure they type yes, this is a big deal command
if [ "$yesprompt" != "yes" ]; then
  elmslnwarn "please type yes to execute the script, exited early"
  exit 1
fi

#prevent the script from being run more than once
if [ -f /tmp/elmsln-upgrade-lock ]; then
  elmslnwarn 'elmsln-upgrade-lock is in place, this command must have failed previously or is currently already running.'
  elmslnwarn "in order to override this manually you'll have to run rm /tmp/elmsln-upgrade-lock"
  exit 1
fi
start="$(timestamp)"
echo "$(date +%T) job started"
# issue the git pull to version selected at commandline
cd ../..
git pull origin $1 || (elmslnwarn "git pull failed, make sure you sync correctly" && exit 1)

touch /tmp/elmsln-upgrade-lock
# stacks we currently only care about as stand alone
standalone=('online' 'media')
for stack in "${standalone[@]}"
do
  elmslnecho "working against $stack"
  # alias to take each site offline
  elmslnecho "$stack: rebuilding registry to avoid file location issues"
  drush @${stack}-all rr --y
  elmslnecho "$stack: sites currently offline to avoid write issues"
  drush @${stack}-all offline --y
  elmslnecho "$stack: running potential database updates"
  drush @${stack}-all updb --y
  # alias to bring them all back online
  elmslnecho "$stack: sites should be back online"
  drush @${stack}-all online --y
  # run these post bringing back online to avoid cache hits of offline pages
  elmslnecho "$stack: execute cron"
  drush @${stack}-all cron --y
  elmslnecho "$stack: clearing caches"
  drush @${stack}-all cc all --y
done
# this only makes sense for online
elmslnecho "online: seed entity / front facing caches"
drush @online-all hss --y

# stacks we currently support spidering against individual networks
masterstacklist=('studio' 'interact' 'blog')
stackdir=$elmsln/core/dslmcode/stacks
empty=""
primarystack='courses'

if [ -d $stackdir/$primarystack/sites/$primarystack/$host ];
then
  fullpath=$stackdir/$primarystack/sites/$primarystack/$host
  # do a find in this directory
  for course in $stackdir/$primarystack/sites/$primarystack/$host/*/settings.php ;
  do
    coursemachinename=""
    # drop /settings.php from the path and split based on / for directories
    IFS='/' read -ra folder <<< "${course/\/settings.php/$empty}"
    for foldername in "${folder[@]}"; do
      # the last one is gaurenteed to be the course!
      coursemachinename=$foldername
    done
    # make sure we found a course
    if [ "$coursemachinename" != "$empty" ]; then
      elmslnecho "${bldgrn}$coursemachinename: working against course network ${txtreset}"
      # networks can be custom, lets see what tools this one uses
      stacklist=($primarystack)
      for stack in "${masterstacklist[@]}"
      do
        # if we found a settings.php here then we know we have a valid service
        if [ -f $stackdir/$stack/sites/$stack/$host/$coursemachinename/settings.php ]; then
          stacklist=("${stacklist[@]}" "$stack")
        fi
      done
      elmslnecho "$coursemachinename: rebuilding registry to avoid file location issues"
      for stack in "${stacklist[@]}"
      do
        elmslnecho "${stack}"
        drush @${stack}.${coursemachinename} rr --y
      done
      elmslnecho "$coursemachinename: take network offline to avoid write issues"
      for stack in "${stacklist[@]}"
      do
        # alias to take each site offline
        elmslnecho "${stack}"
        drush @${stack}.${coursemachinename} offline --y
      done
      elmslnecho "$coursemachinename: running potential database updates"
      for stack in "${stacklist[@]}"
      do
        elmslnecho "${stack}"
        drush @${stack}.${coursemachinename} updb --y
      done
      elmslnecho "$coursemachinename: bring network back online"
      for stack in "${stacklist[@]}"
      do
        # alias to bring site back online
        elmslnecho "${stack}"
        drush @${stack}.${coursemachinename} online --y
      done
      elmslnecho "$coursemachinename: executing cron"
      for stack in "${stacklist[@]}"
      do
        elmslnecho "${stack}"
        drush @${stack}.${coursemachinename} cron --y
      done
      elmslnecho "$coursemachinename: clearing caches"
      for stack in "${stacklist[@]}"
      do
        elmslnecho "${stack}"
        drush @${stack}.${coursemachinename} cc all --y
      done
      elmslnecho "$coursemachinename:$stack seed caches"
      for stack in "${stacklist[@]}"
      do
        elmslnecho "${stack}"
        drush @${stack}.${coursemachinename} ecl --y
      done
      elmslnecho "$coursemachinename network upgrade complete"
    fi
  done
  elmslnecho "ELMSLN network wide upgrade complete"
fi
end="$(timestamp)"
elmslnecho "job took $(expr $end - $start) seconds to run"
rm /tmp/elmsln-upgrade-lock