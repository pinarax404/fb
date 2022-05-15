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

def starting():
    get_ip = requests.get('https://ipwhois.app/json/').json()
    ip = get_ip['ip']
    country = get_ip['country']
    print("IP : " + ip + " || Country : " + country + "")
    starting()

if __name__ == '__main__':
    starting()
