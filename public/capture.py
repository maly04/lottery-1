from selenium import webdriver
from PIL import Image

driver = webdriver.Firefox()
driver.get('https://www.leboncoin.fr/')

# now that we have the preliminary stuff out of the way time to get that image :D
element = driver.find_element_by_id('Calque_1') # find part of the page you want image of
location = element.location
size = element.size
driver.save_screenshot('screenshot.png') # saves screenshot of entire page
driver.quit()

im = Image.open('screenshot.png') # uses PIL library to open image in memory

left = location['x']
top = location['y']
right = location['x'] + size['width']
bottom = location['y'] + size['height']


im = im.crop((left, top, right, bottom)) # defines crop points
im.save('screenshot.png') # saves new cropped image
#driver.close()