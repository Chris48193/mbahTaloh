import sys
import wx

players = [('Tendulkar', '15000', '100'), ('Dravid', '14000', '1'), 
   ('Kumble', '1000', '700'), ('KapilDev', '5000', '400'), 
   ('Ganguly', '8000', '50')] 
	
class Mywin(wx.Frame): 
            
   def __init__(self, parent, title): 
      super(Mywin, self).__init__(parent, title = title) 
		
      panel = wx.Panel(self) 
      box = wx.BoxSizer(wx.VERTICAL)

      #self.list = wx.ListCtrl(panel, -1, style = wx.LC_LIST)

      self.list = wx.ListCtrl(panel, 1, style = wx.LC_REPORT | wx.LC_NO_HEADER)

      self.column1 = self.list.InsertColumn(0, '', width = 70)
      self.column1 = self.list.InsertColumn(0, '', width = 70)
      self.list.InsertColumn(1, '', wx.LIST_FORMAT_RIGHT, 70)
      self.list.InsertColumn(2, '', wx.LIST_FORMAT_RIGHT, 70)
      
      index = self.list.InsertStringItem(100000, 'Identity')
      print(index)
      self.list.SetStringItem(index, 2, 'Cars')

      index = self.list.InsertStringItem(100000, 'Name')
      print(index)
      self.list.SetStringItem(index, 1, 'Surname')
      self.list.SetStringItem(index, 2, 'Model')
      self.list.SetStringItem(index, 3, 'Info')

      for i in players: 
         index = self.list.InsertStringItem(100000, i[0])
         print(index)
         self.list.SetStringItem(index, 1, i[1]) 
         self.list.SetStringItem(index, 2, i[2])
			
      #box.Add(self.list1,1,wx.EXPAND)
      box.Add(self.list,2,wx.EXPAND) 
      panel.SetSizer(box) 
      panel.Fit() 
      self.Centre() 
         
      self.Show(True)  
     
ex = wx.App() 
Mywin(None,'ListCtrl Demo') 
ex.MainLoop()