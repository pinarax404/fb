# testing aja

import mechanize
import requests
import re
import bs4
import logging
import argparse
import sys

reload(sys)
sys.setdefaultencoding('utf8')

def get_ip():
    get_ip = requests.get('https://ipwhois.app/json/').json()
    return {
        'ip':  get_ip['ip'],
        'country':  get_ip['country']
    }

def starting():
    get_ip = get_ip()
    print("IP : " + get_ip['ip'] + " || Country : " + get_ip['country'] + "\n")
    starting()

if __name__ == '__main__':
    starting()
