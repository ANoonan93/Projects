from django import forms
from .models import SignUp

class ContactForm(forms.Form):
    full_name = forms.CharField(required=False)
    email = forms.EmailField()
    message = forms.CharField(widget= forms.Textarea)


class SignUpForm(forms.ModelForm):
    class Meta:
        model = SignUp
        fields = ['fullname','email']

    def clean_email(self):
        email = self.cleaned_data.get('email')
        email_base, provider = email.split("@")
        domain, extension = provider.split(".")
        #if not extension == ".com":
            #raise forms.ValidationError("Please enter an email with .com ")
        return email

    def clean_full_name(self):
        full_name = self.cleaned_data.get("full_name")
        return full_name

class PreferencesForm(forms.Form):
    coordinates = forms.CharField(max_length=200, required=True)
    place_name = forms.CharField(max_length=100, required=True)
    description = forms.CharField(widget=forms.Textarea)

    def clean_data(self):
        cleaned_data = self.cleaned_data

        coordinates = cleaned_data.get("coordinates")
        place_name = cleaned_data.get("place_name")
        description = cleaned_data.get("description")

        return cleaned_data