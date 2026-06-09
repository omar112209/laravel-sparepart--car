import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable
import keywords.common_keywords

WebUI.openBrowser('')
WebUI.maximizeWindow()

common_keywords keywords = new common_keywords()
keywords.loginAsAdmin()

WebUI.navigateToUrl(GlobalVariable.APP_URL + "/backend/kategori")
WebUI.verifyElementPresent(findTestObject('Page_Kategori/heading_kategori'), 5, FailureHandling.CONTINUE_ON_FAILURE)
WebUI.comment("Halaman kategori terbuka")

WebUI.click(findTestObject('Page_Kategori/btn_tambah_kategori'))
WebUI.verifyElementPresent(findTestObject('Page_Kategori/form_nama_kategori'), 5, FailureHandling.CONTINUE_ON_FAILURE)

String kategoriName = "Test Katalon " + System.currentTimeMillis()
WebUI.setText(findTestObject('Page_Kategori/form_nama_kategori'), kategoriName)
WebUI.click(findTestObject('Page_Kategori/btn_simpan'))

WebUI.delay(1)
WebUI.comment("Kategori berhasil dibuat: " + kategoriName)
WebUI.takeScreenshot('Screenshots/TC_ManageCategories.png')
WebUI.closeBrowser()
