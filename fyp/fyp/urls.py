"""fyp URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/1.9/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  url(r'^$', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  url(r'^$', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.conf.urls import url, include
    2. Add a URL to urlpatterns:  url(r'^blog/', include('blog.urls'))
"""
from django.conf import settings
from django.conf.urls import include, url
from django.conf.urls.static import static
from django.contrib import admin

from app import views

urlpatterns = [
    url(r'^$', views.home, name='home'),
    url(r'^about/$', views.about, name='about'),
    url(r'^contact/$', views.contact, name='contact'),
    url(r'^current_weather/$', views.current_weather, name='current_weather'),
    url(r'^forecast_weather/$', views.forecast_weather, name='forecast_weather'),
    url(r'^location/$', views.location, name='location'),
    url(r'^help/$', views.help, name='help'),
    url(r'^preferences/&', views.preference, name='preferences'),
    url(r'^preferences/success/&', views.preference, name='pref_success'),
    url(r'^preferences/error/&', views.preference, name='pref_error'),

    url(r'^admin/', include(admin.site.urls)),
    url(r'^accounts/', include('registration.backends.default.urls')),
]+ static(settings.STATIC_URL, document_root = settings.STATIC_ROOT)#appends static files to url

if settings.DEBUG:
    urlpatterns += static(settings.STATIC_URL, document_root = settings.STATIC_ROOT)
    urlpatterns += static(settings.MEDIA_URL, document_root = settings.MEDIA_ROOT)
