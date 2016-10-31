#!/usr/bin/env python
from selenium import webdriver
#pip install image
from PIL import Image
import httplib
from selenium.webdriver.support.ui import Select
import time
import sys

try:

    #get arguments
    params = sys.argv
    # print(sys.argv)

    # driver = webdriver.Firefox()
    driver = webdriver.PhantomJS(executable_path = 'phantomjs')
    driver.set_window_size(1800, 700)

    driver.get('http://188.166.234.165/lottery/public/login')

    #login
    driver.find_element_by_id("userName").send_keys("admin")
    driver.find_element_by_name("password").send_keys("123456")
    driver.find_element_by_css_selector('footer button').click()

    #go to report page
    driver.get('http://188.166.234.165/lottery/public/report')

    #filter report
    driver.find_element_by_id("dateStart").send_keys( str(params[2]) )

    select = Select(driver.find_element_by_css_selector('#staff'))
    select.select_by_value( str(params[3]) )

    if str(params[4]) != '0':
        select = Select(driver.find_element_by_css_selector('#sheet'))
        select.select_by_value( str(params[4]) )

    if str(params[5]) != '0':
        select = Select(driver.find_element_by_css_selector('#pages'))
        select.select_by_value( str(params[5]) )

    #submit filter
    driver.find_element_by_css_selector('.btn-filter').click()

    # now that we have the preliminary stuff out of the way time to get that image :D
    element = driver.find_element_by_css_selector('#'+str(params[1])) # find part of the page you want image of
    location = element.location
    size = element.size

    #generate file name
    timestamp = int(time.time())
    screen_name = str(timestamp) + '.png'
    print(screen_name)
    driver.save_screenshot(screen_name) # saves screenshot of entire page
    time.sleep(3)

    im = Image.open(screen_name) # uses PIL library to open image in memory

    left = location['x']
    top = location['y']
    right = location['x'] + size['width']
    bottom = location['y'] + size['height']


    im = im.crop((int(left), int(top), int(right), int(bottom))) # defines crop points
    im.save(screen_name) # saves new cropped image
    driver.quit()

except httplib.BadStatusLine:
    pass
