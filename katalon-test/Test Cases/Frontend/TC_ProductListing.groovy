import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable

WebUI.openBrowser('')
WebUI.maximizeWindow()
WebUI.navigateToUrl(GlobalVariable.APP_URL + "/produk/all")

WebUI.verifyElementPresent(findTestObject('Page_Produk/heading_produk'), 5, FailureHandling.CONTINUE_ON_FAILURE)

int totalProduk = WebUI.findWebElements(findTestObject('Page_Produk/card_produk'), 5).size()
WebUI.comment("Total produk ditampilkan: " + totalProduk)
assert totalProduk > 0 : "Tidak ada produk yang ditampilkan!"

WebUI.takeScreenshot('Screenshots/TC_ProductListing.png')
WebUI.closeBrowser()
