import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable

WebUI.openBrowser('')
WebUI.maximizeWindow()
WebUI.navigateToUrl(GlobalVariable.APP_URL + "/backend/login")

WebUI.verifyElementPresent(findTestObject('Page_BackendLogin/input_email'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.verifyElementPresent(findTestObject('Page_BackendLogin/input_password'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.verifyElementPresent(findTestObject('Page_BackendLogin/btn_submit'), 5, FailureHandling.CONTINUE_ON_FAILURE)

WebUI.setText(findTestObject('Page_BackendLogin/input_email'), GlobalVariable.ADMIN_EMAIL)
WebUI.setText(findTestObject('Page_BackendLogin/input_password'), GlobalVariable.ADMIN_PASSWORD)
WebUI.click(findTestObject('Page_BackendLogin/btn_submit'))

WebUI.delay(2)

String currentUrl = WebUI.getUrl()
assert currentUrl.contains("/backend/beranda") : "Login gagal! URL saat ini: " + currentUrl
WebUI.comment("Login admin berhasil!")

WebUI.takeScreenshot('Screenshots/TC_AdminLogin.png')
WebUI.closeBrowser()
