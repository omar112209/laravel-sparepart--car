import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable

WebUI.openBrowser('')
WebUI.maximizeWindow()
WebUI.navigateToUrl(GlobalVariable.APP_URL + "/produk/all")

WebUI.click(findTestObject('Page_Produk/card_produk_pertama'))

WebUI.verifyElementPresent(findTestObject('Page_ProdukDetail/heading_nama_produk'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.verifyElementPresent(findTestObject('Page_ProdukDetail/label_harga'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.verifyElementPresent(findTestObject('Page_ProdukDetail/btn_tambah_keranjang'), 5, FailureHandling.CONTINUE_ON_FAILURE)

String namaProduk = WebUI.getText(findTestObject('Page_ProdukDetail/heading_nama_produk'))
WebUI.comment("Detail produk: " + namaProduk)

WebUI.takeScreenshot('Screenshots/TC_ProductDetail.png')
WebUI.closeBrowser()
