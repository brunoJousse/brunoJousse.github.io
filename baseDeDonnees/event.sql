Create event supprimeCoursePlusDUneSemaine on schedule every 1 day starts '2017-03-11 00:00:00' do
DELETE from inf345_30.Itineraire where DATEDIFF(NOW(), dateDepart)>=7;

Create event DesactiveCoursesFinie on schedule every 1 day starts '2017-03-11 00:00:00' do
UPDATE inf345_30.Itineraire set active=false where dateDepart<NOW();