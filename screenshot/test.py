#!/usr/bin/env python
from selenium import webdriver
#pip install image
from PIL import Image
from selenium.webdriver.support.ui import Select
import time
import sys

#get arguments
params = sys.argv
# print(sys.argv)

#get arguments
params = sys.argv
#print(sys.argv)

# driver = webdriver.Firefox()
driver = webdriver.PhantomJS(executable_path = '/usr/local/bin/phantomjs')
print(driver)
driver.set_window_size(1800, 700)

driver.get('http://188.166.234.165/lottery/public/login')

#login
driver.find_element_by_id("userName").send_keys("admin")
driver.find_element_by_name("password").send_keys("123456")
driver.find_element_by_css_selector('footer button').click()


#generate file name
timestamp = int(time.time())
screen_name = str(timestamp) + '.png'
print(screen_name)
driver.save_screenshot(screen_name) # saves screenshot of entire page
driver.quit()

im = Image.open(screen_name) # uses PIL library to open image in memory

left = location['x']
top = location['y']
right = location['x'] + size['width']
bottom = location['y'] + size['height']


im = im.crop((int(left), int(top), int(right), int(bottom))) # defines crop points
im.save(screen_name) # saves new cropped image