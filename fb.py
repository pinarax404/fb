import mechanize
import requests
import re
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
        self.__main__()

    def _browser_options(self):
        br = mechanize.Browser()
        br.set_handle_robots(False)
        br.set_handle_equiv(True)
        br.set_handle_referer(True)
        br.set_handle_redirect(True)
        if arg.proxy:
            br.set_proxies({"http": arg.proxy,
                            "https": arg.proxy,
                            })
        br.set_handle_refresh(
            mechanize._http.HTTPRefreshProcessor(),
            max_time = 5
        )
        br.addheaders = [('User-agent', "Mozilla/5.0 (Linux; Android 5.0; ASUS_T00G Build/LRX21V) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36")]

        return br

    # info account
    def _get_info_account(self):
        logging.info('looking for account information')
        res = requests.get('https://randomuser.me/api').json()

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

        body_fb_1 = 'lsd=AVpe3mSRRXU&jazoest=2944&ccp=2&reg_instance=cU6AYhhg7IDdlZCPbBgtM4yJ&submission_request=true&helper=&reg_impression_id=b29dce9e-5c7f-4019-b44a-4329af16050b&ns=0&zero_header_af_client=&app_id=&logger_id=&field_names%5B%5D=firstname&field_names%5B%5D=reg_email__&field_names%5B%5D=sex&field_names%5B%5D=birthday_wrapper&field_names%5B%5D=reg_passwd__&firstname=anna&lastname=zaza&reg_email__=cukbfjwi0it@blondemorkin.com&sex=1&custom_gender=&did_use_age=false&birthday_month=5&birthday_day=14&birthday_year=2000&age_step_input=&reg_passwd__=badaklepas123&submit=Sign+Up'
        post_fb_1 = requests.post('https://m.facebook.com/reg/submit/', data=body_fb_1).json()
        logging.info(post_fb_1)

    def _check_email_fb(self, email):
        return True

    def _submit_code(self, code):
        self.br._factory.is_html = True
        self.br.select_form(nr=0)
        self.br.form['n'] = code
        self.br.submit()

    def _change_password(self):
        data = self._get_info_account()
        self._password = data['password']

        self.br._factory.is_html = True
        self.br.select_form(nr=0)
        self.br.form['password_new'] = self._password
        self.br.submit()

    # mail
    def _open_temp_mail(self):
        body_mail = {'min_name_length':10,'max_name_length':10}
        get_mail = requests.post('https://api.internal.temp-mail.io/api/v3/email/new', data=body_mail).json()
        return get_mail['email']

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
            logging.info('searching new emails')

            email_found, check, max_ = False, True, 0
            while True:
                self._mail = self._open_temp_mail()

                if not email_found:
                    logging.info('obtained email: %s', self._mail)
                    if self._check_email_fb(self._mail):
                        if self._create_account_facebook(self._mail):
                            email_found = True
                    else:
                        logging.info('waiting for incoming email')
                        code = self._read_message(res_em)
                        if code:
                            self._submit_code(code)

                if max_ == 10:
                    logging.error('no response !')
                    break
                if check and email_found:
                    self.create_total += 1
                    logging.info('account created:\n\t   email: %s\n\t   password: %s', self._mail, self._password)
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
#        except Exception as exc:
 #           logging.critical(str(exc) + '\n')
    else:
        parse.print_help()
