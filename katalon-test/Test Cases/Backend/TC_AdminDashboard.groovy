import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable
import keywords.common_keywords

WebUI.openBrowser('')
WebUI.maximizeWindow()

common_keywords keywords = new common_keywords()
keywords.loginAsAdmin()

WebUI.verifyElementPresent(findTestObject('Page_BackendDashboard/sidebar_menu'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.verifyElementPresent(findTestObject('Page_BackendDashboard/card_statistik'), 5, FailureHandling.CONTINUE_ON_FAILURE)

WebUI.takeScreenshot('Screenshots/TC_AdminDashboard.png')
WebUI.closeBrowser()
