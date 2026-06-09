import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable
import keywords.common_keywords

WebUI.openBrowser('')
WebUI.maximizeWindow()

common_keywords keywords = new common_keywords()
keywords.loginAsAdmin()

WebUI.navigateToUrl(GlobalVariable.APP_URL + "/backend/pesanan/proses")
WebUI.verifyElementPresent(findTestObject('Page_Pesanan/heading_pesanan'), 5, FailureHandling.CONTINUE_ON_FAILURE)

WebUI.navigateToUrl(GlobalVariable.APP_URL + "/backend/pesanan/selesai")
WebUI.verifyElementPresent(findTestObject('Page_Pesanan/heading_pesanan'), 5, FailureHandling.CONTINUE_ON_FAILURE)

WebUI.comment("Menu pesanan proses & selesai dapat diakses")
WebUI.takeScreenshot('Screenshots/TC_ManageOrders.png')
WebUI.closeBrowser()
