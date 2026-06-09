package keywords

import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI

class common_keywords {
	def loginAsAdmin() {
		WebUI.navigateToUrl(GlobalVariable.APP_URL + "/backend/login")
		WebUI.setText(findTestObject('Page_Login/input_email'), GlobalVariable.ADMIN_EMAIL)
		WebUI.setText(findTestObject('Page_Login/input_password'), GlobalVariable.ADMIN_PASSWORD)
		WebUI.click(findTestObject('Page_Login/btn_submit'))
		WebUI.delay(1)
	}
}
