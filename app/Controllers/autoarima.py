import numpy as np # linear algebra
import pandas as pd # data processing, CSV file I/O (e.g. pd.read_csv)
#%matplotlib inline
import matplotlib.pyplot as plt
from statsmodels.tsa.arima_model import ARIMA
import pmdarima as pm
from math import sqrt
from pmdarima.metrics import smape

df = pd.read_csv('C:/xampp/htdocs/web/bismillahAkhir/public/data.csv', names=['value'])

#divide into train and validation set
train = df[:int(0.7*(len(df)))]
valid = df[int(0.7*(len(df))):]

# Seasonal True dan m=12 karena dataset merupakan data bulanan dari 12 bulan
model = pm.auto_arima(df.value, start_p=0, start_q=0,
                      test='adf',           # use adftest to find optimal 'd'
                      max_p=5, max_q=3,     # maximum p and q
                      m=12,                 # frequency of series (Data ada 1 tahun 12 bulan)
                      seasonal=True,        # Data bulanan,
                      D=1,                  # Data per satubulan
                      trace=True,
                      error_action='ignore',  
                      suppress_warnings=True, 
                      stepwise=True
                      )

# Non-Seasonal
# model = pm.auto_arima(df.value, start_p=0, start_q=0,
#                       test='adf',       # use adftest to find optimal 'd'
#                       max_p=5, max_q=3, # maximum p and q
#                       m=1,              # frequency of series
#                       d=None,           # let model determine 'd' (differencing)
#                       seasonal=False,   # No Seasonality
#                       start_P=0, 
#                       start_Q=0,
#                       D=0, 
#                       trace=True,
#                       error_action='ignore',  
#                       suppress_warnings=True, 
#                       stepwise=True)

# Forecast for accuracy
forecast = model.predict(n_periods=len(valid))
forecast = pd.DataFrame(forecast,index = valid.index,columns=['Prediction'])

#calculate mape
from math import sqrt
from pmdarima.metrics import smape
from sklearn.metrics import mean_squared_error

# mse = mean_squared_error(valid,forecast)
difference_array = np.subtract(valid, forecast)
squared_array = np.square(difference_array)
mse = squared_array.mean()

mape = sqrt(smape(valid,forecast))
print('MAPE : ', mape)
print('MSE : ', mse)

######################################################################################
# model = pm.auto_arima(df.value, start_p=0, start_q=0,
#                       test='adf',       # use adftest to find optimal 'd'
#                       max_p=5, max_q=3, # maximum p and q
#                       m=12,              # frequency of series
#                       seasonal=True,   # Data bulanan
#                       trace=True,
#                       error_action='ignore',  
#                       suppress_warnings=True, 
#                       stepwise=True)
######################################################################################

# Forecast
n_periods = 12
fc, confint = model.predict(n_periods=n_periods, return_conf_int=True)
index_of_fc = np.arange(len(df.value), len(df.value)+n_periods)

# make series for plotting purpose
fc_series = pd.Series(fc, index=index_of_fc)
lower_series = pd.Series(confint[:, 0], index=index_of_fc)
upper_series = pd.Series(confint[:, 1], index=index_of_fc)

# print(upper_series)
# print(lower_series)
# print(upper_series)

# Plot Data
fig = plt.figure()
ax = fig.add_subplot()
fig.subplots_adjust(top=0.85)

ax.set_xlabel('Bulan ke-')
ax.set_ylabel('Nominal')

plt.plot(df.value)

plt.plot(fc_series, color='darkgreen')
plt.fill_between(lower_series.index, 
                 lower_series, 
                 upper_series, 
                 color='k', alpha=.15)

plt.title("Hasil Peramalan (Error: %.3f persen)" % mape)
# Ubah ke format angka asli
# ax.ticklabel_format(useOffset=False, style='plain')
plt.show()