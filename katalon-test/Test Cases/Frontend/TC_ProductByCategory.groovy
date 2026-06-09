import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable

WebUI.openBrowser('')
WebUI.maximizeWindow()
WebUI.navigateToUrl(GlobalVariable.APP_URL)

WebUI.click(findTestObject('Page_Beranda/link_kategori_pertama'))

WebUI.verifyElementPresent(findTestObject('Page_Produk/heading_produk'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.comment("Navigasi kategori berhasil")

WebUI.takeScreenshot('Screenshots/TC_ProductByCategory.png')
WebUI.closeBrowser()
