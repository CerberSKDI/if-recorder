#!/usr/bin/env python

from __future__ import absolute_import
from __future__ import division
from __future__ import print_function

import sys
import re
import subprocess

regex_debug = re.compile(b';;;.+$', re.M)


def compress_source(target, srcls):
    print('Writing', target)
    with open(target, 'wb') as targetfl:
        proc = subprocess.Popen([sys.executable, 'rjsmin.py'],
                                stdin=subprocess.PIPE,
                                stdout=targetfl)
        for src in srcls:
            with open(src, 'rb') as fl:
                dat = fl.read()
            dat = regex_debug.sub(b'', dat)
            proc.stdin.write(dat)
        proc.stdin.close()
        ret = proc.wait()
        if (ret):
            raise Exception('Process result code %d' % (ret,))

compress_source(
    '../lib/if-recorder.min.js', [
        '../src/if-recorder.js',
        ])
