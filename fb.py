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

class create:
    def __init__(self):
        logging.basicConfig(
            level={
                True: logging.DEBUG,
                False: logging.INFO
            }[arg.level],
            format='\r%(levelname)s:%(name)s: %(message)s'
        )
        self.create_total = 0
        self.blacklist_email = [] #'@datasoma', '@geroev', '@cliptik', '@khtyler', '@parcel4']
        self.temp_email_url = 'https://csrng.net/csrng/csrng.php?min=111111111&max=999999999'

        self.__main__()

    def _browser_options(self):
        br = mechanize.Browser()
        br.set_handle_robots(False)
        br.set_handle_equiv(True)
        br.set_handle_referer(True)
        br.set_handle_redirect(True)
        br.set_handle_refresh(
            mechanize._http.HTTPRefreshProcessor(),
            max_time = 5
        )
        br.addheaders = [('User-agent', "Mozilla/5.0 (Linux; Android 11) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36")]

        return br

    # info account
    def _get_info_account(self):
        logging.info('looking for account information')
        res = requests.get('https://randomuser.me/api/?gender=female&nat=us').json()

        pwd = res['results'][0]['login']['password']
        return {
            'username':  res['results'][0]['login']['username'],
            'password':  'badaklepas123',
            'firstname': res['results'][0]['name']['first'],
            'lastname':  res['results'][0]['name']['last'],
            'gender':    '1' if res['results'][0]['gender'] == 'female' else '2',
            'date':      res['results'][0]['dob']['date'].split('T')[0].split('-')
        }

    # facebook
    def _create_account_facebook(self, email):
        data = self._get_info_account()

        self._password = data['password']
        logging.info('name: %s', data['firstname'] + ' ' + data['lastname'])
        logging.info('create a facebook account')
        self.br.open('https://mbasic.facebook.com/reg/?cid=103&refsrc=deprecated&soft=hjk')

        self.br.select_form(nr=0)
        self.br.form['firstname'] = data['firstname'] + ' ' + data['lastname']
        try:
            self.br.form['reg_email__'] = email
        except mechanize._form_controls.ControlNotFoundError as ex:
            logging.warning(str(ex))
            return False

        self.br.form['sex'] = [data['gender']]
        self.br.form['birthday_day'] = [data['date'][2][1:] if data['date'][2][0] == '0' else data['date'][2]]
        self.br.form['birthday_month'] = [data['date'][1][1:] if data['date'][1][0] == '0' else data['date'][1]]
        self.br.form['birthday_year'] = [data['date'][0]]
        self.br.form['reg_passwd__'] = data['password']
        self.br.submit()

        if "kesalahan" in self.br.response().read().lower():
            sys.exit(logging.error("Kesalahan....\n"))

        if "error" in self.br.response().read().lower():
            sys.exit(logging.error("Error....\n"))

        if "checkpoint" in self.br.response().read().lower():
            sys.exit(logging.error("Checkpoint...\n"))

        if "spam" in self.br.response().read().lower():
            sys.exit(logging.error("IP Banned....\n"))

        for i in range(3):
            self.br.select_form(nr=0)
            self.br.submit()

        return True

    def _check_email_fb(self, email):
        return True

    # mail
    def _open_temp_mail(self):
        res = requests.get(self.temp_email_url).json()
        return '+6285' + str(res[0]['random'])

    def _read_message(self, text):
        x = re.findall(r'baslik">(\d+)\s', text)
        if x:
            logging.info("your code: %s" % x[0])
            return True

    def _save_to_file(self, email, password):
        with open('akun.txt', 'a') as f:
            f.write('%s|%s\n' % (email, password))

    def __main__(self):
        while True:
            self.br = self._browser_options()
            logging.info('Generating Number')

            email_found, check, max_ = False, True, 0
            while True:
                self._mail = self._open_temp_mail()

                if not email_found:
                    logging.info('Phone Number: %s', self._mail)
                    if self._check_email_fb(self._mail):
                        if self._create_account_facebook(self._mail):
                            email_found = True
                if max_ == 10:
                    logging.error('no response !')
                    break
                if check and email_found:
                    self.create_total += 1
                    logging.info('account created:\n\t   number: %s\n\t   password: %s', self._mail, self._password)
                    self._save_to_file(self._mail, self._password)
                    check = False
                    max_ += 1
                else: break

            if self.create_total == arg.count:
                logging.info('finished\n')
                break

if __name__ == '__main__':
    parse = argparse.ArgumentParser()
    parse.add_argument( '-c', metavar='<COUNT>', type=int, dest='count',
        help='number of accounts you want to make')
    parse.add_argument( '-p', metavar='<IP:PORT>', dest='proxy',
        help='set proxy')
    parse.add_argument('--debug', action='store_true', dest='level',
        help='set logging level to debug')
    arg = parse.parse_args()

    if arg.count:
        try:
            print ('') # new line
            create()
        except KeyboardInterrupt:
            logging.error('user interrupt..\n')
        except Exception as exc:
            logging.critical(str(exc) + '\n')
    else:
        parse.print_help()
