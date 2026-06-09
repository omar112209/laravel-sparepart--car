import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable

WebUI.openBrowser('')
WebUI.maximizeWindow()
WebUI.navigateToUrl(GlobalVariable.APP_URL + "/history")

WebUI.delay(2)
String currentUrl = WebUI.getUrl()
WebUI.comment("Halaman riwayat order: " + currentUrl)

WebUI.takeScreenshot('Screenshots/TC_OrderHistory.png')
WebUI.closeBrowser()
