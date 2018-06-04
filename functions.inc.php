<?php
#
#    Copyright (C) 2018 Nethesis S.r.l.
#    http://www.nethesis.it - support@nethesis.it
#
#    This file is part of RapidCode FreePBX module.
#
#    RapidCode module is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or any
#    later version.
#
#    RapidCode module is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with RapidCode module.  If not, see <http://www.gnu.org/licenses/>.
#

function rapidcode_get_config($engine) {
    $modulename = 'rapidcode';
    global $ext;
    switch($engine) {
        case "asterisk":
            if (is_array($featurelist = featurecodes_getModuleFeatures($modulename))) {
                foreach ($featurelist as $f) {
                    if ($f['featurename'] !== 'rapidcode') {
                        continue;
                    }
                    if (empty($f['code'])) {
                        $f['code'] = '*0'; // *0 is the default feature code fo RapidCode
                    }
                    $c = '_'.$f['code'].'.';
                    $context = 'app-rapidcode';
                    // add app-rapidcode to from-internal-additional context
                    $ext->addInclude('from-internal-additional', $context);
                    // create RAPIDCODENUM empty variable
                    $ext->add($context, $c, '', new ext_setvar('RAPIDCODENUM',''));
                    // execute AGI
                    $ext->add($context, $c, '', new ext_agi('rapidcode.php,${EXTEN},'.$f['code']));
                    // if RAPIDCODENUM is still empty goto fail
                    $ext->add($context, $c, '', new ext_gotoif('$[ "foo${RAPIDCODENUM}" = "foo" ]', 'fail'));
                    // call RAPIDCODENUM
                    $ext->add($context, $c, '', new ext_goto('outbound-allroutes,${RAPIDCODENUM},1'));
                    // fail
                    $ext->add($context, $c, 'fail', new ext_playback('pbx-invalid'));
                    $ext->add($context, $c, '', new ext_hangup());
                }
            }
        break;
    }
}
