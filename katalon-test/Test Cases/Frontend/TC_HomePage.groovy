import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable

WebUI.openBrowser('')
WebUI.maximizeWindow()
WebUI.navigateToUrl(GlobalVariable.APP_URL)

WebUI.verifyElementPresent(findTestObject('Page_Beranda/header_logo'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.verifyElementPresent(findTestObject('Page_Beranda/section_produk'), 5, FailureHandling.CONTINUE_ON_FAILURE)

WebUI.takeScreenshot('Screenshots/TC_HomePage.png')
WebUI.closeBrowser()
