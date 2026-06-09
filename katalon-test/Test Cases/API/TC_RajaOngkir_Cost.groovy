import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.testobject.RequestObject
import com.kms.katalon.core.testobject.ResponseObject
import com.kms.katalon.core.testobject.ConditionType
import com.kms.katalon.core.testobject.TestObjectProperty
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import internal.GlobalVariable

def request = new RequestObject("POST_Cost")
request.setRestUrl(GlobalVariable.APP_URL + "/cost")
request.setHttpHeaderProperties([
	new TestObjectProperty("Content-Type", ConditionType.EQUALS, "application/x-www-form-urlencoded")
])
request.setBody("origin=1&destination=2&weight=1000&courier=jne")

def response = WS.sendRequest(request)

WS.verifyResponseStatusCode(response, 200)
WS.comment("API RajaOngkir - Cost: OK")
