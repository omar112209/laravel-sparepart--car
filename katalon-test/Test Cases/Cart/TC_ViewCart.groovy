import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable

WebUI.openBrowser('')
WebUI.maximizeWindow()

WebUI.navigateToUrl(GlobalVariable.APP_URL + "/cart")
WebUI.delay(2)

String currentUrl = WebUI.getUrl()
WebUI.comment("Halaman cart: " + currentUrl)
WebUI.verifyElementPresent(findTestObject('Page_Cart/heading_cart'), 5, FailureHandling.CONTINUE_ON_FAILURE)

WebUI.takeScreenshot('Screenshots/TC_ViewCart.png')
WebUI.closeBrowser()
