import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable

WebUI.openBrowser('')
WebUI.maximizeWindow()
WebUI.navigateToUrl(GlobalVariable.APP_URL + "/produk/detail/1")

WebUI.click(findTestObject('Page_ProdukDetail/btn_tambah_keranjang'))

WebUI.delay(2)

String currentUrl = WebUI.getUrl()
boolean redirectedToLogin = currentUrl.contains("auth/redirect") || currentUrl.contains("login")
WebUI.comment("Tanpa login, redirect ke halaman login: " + redirectedToLogin)

WebUI.takeScreenshot('Screenshots/TC_AddToCart_WithoutLogin.png')
WebUI.closeBrowser()
