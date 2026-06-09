import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable

WebUI.openBrowser('')
WebUI.maximizeWindow()

WebUI.navigateToUrl(GlobalVariable.APP_URL + "/select-shipping")
WebUI.delay(2)

String currentUrl = WebUI.getUrl()
WebUI.comment("Halaman shipping: " + currentUrl)

WebUI.verifyElementPresent(findTestObject('Page_Shipping/select_province'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.verifyElementPresent(findTestObject('Page_Shipping/select_city'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.verifyElementPresent(findTestObject('Page_Shipping/select_district'), 5, FailureHandling.CONTINUE_ON_FAILURE)

WebUI.takeScreenshot('Screenshots/TC_CheckoutFlow.png')
WebUI.closeBrowser()
