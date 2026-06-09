import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable
import keywords.common_keywords

WebUI.openBrowser('')
WebUI.maximizeWindow()

common_keywords keywords = new common_keywords()
keywords.loginAsAdmin()

WebUI.navigateToUrl(GlobalVariable.APP_URL + "/backend/produk")
WebUI.verifyElementPresent(findTestObject('Page_ProdukBackend/heading_produk'), 5, FailureHandling.CONTINUE_ON_FAILURE)

WebUI.click(findTestObject('Page_ProdukBackend/btn_tambah_produk'))
WebUI.verifyElementPresent(findTestObject('Page_ProdukBackend/form_nama_produk'), 5, FailureHandling.CONTINUE_ON_FAILURE)

String produkName = "Produk Test " + System.currentTimeMillis()
WebUI.setText(findTestObject('Page_ProdukBackend/form_nama_produk'), produkName)
WebUI.setText(findTestObject('Page_ProdukBackend/form_harga_produk'), "50000")
WebUI.setText(findTestObject('Page_ProdukBackend/form_stok_produk'), "10")

WebUI.selectOptionByIndex(findTestObject('Page_ProdukBackend/select_kategori'), 1)

WebUI.click(findTestObject('Page_ProdukBackend/btn_simpan'))
WebUI.delay(1)

WebUI.comment("Produk berhasil dibuat: " + produkName)
WebUI.takeScreenshot('Screenshots/TC_ManageProducts.png')
WebUI.closeBrowser()
